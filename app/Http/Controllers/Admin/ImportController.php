<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImportBatch;
use App\Models\ImportRow;
use App\Models\Payment;
use App\Models\RevenueItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function index()
    {
        $this->ensureAdmin();

        $imports = ImportBatch::query()
            ->latest()
            ->paginate(20);

        return view('admin.imports.index', compact('imports'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('admin.imports.create');
    }

    public function upload(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'type' => ['required', 'in:payments'],
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:20480'],
        ]);

        $file = $request->file('file');
        $storedPath = $file->store('imports', 'local');

        $batch = ImportBatch::create([
            'created_by' => $request->user()->id,
            'type' => $data['type'],
            'status' => 'uploaded',
            'original_filename' => $file->getClientOriginalName(),
            'stored_path' => $storedPath,
            'total_rows' => 0,
            'valid_rows' => 0,
            'invalid_rows' => 0,
            'imported_rows' => 0,
            'skipped_rows' => 0,
        ]);

        try {
            $count = $this->parseCsvToRows($batch);
            $batch->update(['total_rows' => $count]);
        } catch (\Throwable $e) {
            $batch->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            throw $e;
        }

        return redirect()->route('admin.imports.map', $batch);
    }

    public function map(ImportBatch $import)
    {
        $this->ensureAdmin();

        $first = $import->rows()->orderBy('row_number')->first();
        $headers = $first ? array_keys((array) $first->raw_json) : [];

        $required = $this->requiredFieldsForType($import->type);
        $suggested = $this->suggestedHeaderMap();

        return view('admin.imports.map', compact('import', 'headers', 'required', 'suggested'));
    }

    public function saveMap(Request $request, ImportBatch $import)
    {
        $this->ensureAdmin();

        $required = $this->requiredFieldsForType($import->type);

        $mapping = $request->input('mapping', []);
        if (!is_array($mapping)) {
            $mapping = [];
        }

        foreach ($required as $field) {
            if (empty($mapping[$field])) {
                return back()->withErrors([$field => 'This field is required'])->withInput();
            }
        }

        $import->update([
            'mapping_json' => $mapping,
            'status' => 'mapped',
            'valid_rows' => 0,
            'invalid_rows' => 0,
        ]);

        // Reset row statuses because mapping changed
        $import->rows()->update([
            'status' => 'pending',
            'mapped_json' => null,
            'errors_json' => null,
        ]);

        return redirect()->route('admin.imports.preview', $import);
    }

    public function preview(ImportBatch $import)
    {
        $this->ensureAdmin();

        $mapping = $this->asArray($import->mapping_json);
        if (!$mapping) {
            return redirect()->route('admin.imports.map', $import);
        }

        $valid = 0;
        $invalid = 0;

        $rows = $import->rows()->orderBy('row_number')->get();

        foreach ($rows as $row) {
            $raw = $this->asArray($row->raw_json);

            [$mapped, $errors] = $this->mapAndValidateRow($import->type, $raw, $mapping);

            $row->mapped_json = $mapped;
            $row->errors_json = $errors ?: null;

            if ($errors) {
                $row->status = 'invalid';
                $invalid++;
            } else {
                $row->status = 'valid';
                $valid++;
            }

            $row->save();
        }

        $import->update([
            'status' => 'previewed',
            'valid_rows' => $valid,
            'invalid_rows' => $invalid,
        ]);

        $invalidSample = $import->rows()->where('status', 'invalid')->limit(20)->get();

        return view('admin.imports.preview', compact('import', 'invalidSample'));
    }

    public function run(Request $request, ImportBatch $import)
    {
        $this->ensureAdmin();

        if ($import->status !== 'previewed') {
            return redirect()->route('admin.imports.preview', $import);
        }

        $import->update(['status' => 'importing']);

        $imported = 0;
        $skipped = 0;

        DB::transaction(function () use ($import, &$imported, &$skipped) {
            $rows = $import->rows()
                ->where('status', 'valid')
                ->orderBy('row_number')
                ->lockForUpdate()
                ->get();

            foreach ($rows as $row) {
                $payload = $this->asArray($row->mapped_json);

                if ($import->type === 'payments') {
                    $result = $this->importPaymentRow($payload);
                    if ($result === 'imported') {
                        $row->status = 'imported';
                        $imported++;
                    } else {
                        $row->status = 'skipped';
                        $skipped++;
                    }
                    $row->save();
                }
            }
        });

        $import->update([
            'status' => 'completed',
            'imported_rows' => $imported,
            'skipped_rows' => $skipped,
            'summary_json' => [
                'completed_at' => now()->toDateTimeString(),
            ],
        ]);

        return redirect()->route('admin.imports.show', $import);
    }

    public function show(ImportBatch $import)
    {
        $this->ensureAdmin();

        $stats = [
            'total' => (int) $import->total_rows,
            'valid' => (int) $import->valid_rows,
            'invalid' => (int) $import->invalid_rows,
            'imported' => (int) $import->imported_rows,
            'skipped' => (int) $import->skipped_rows,
            'status' => (string) $import->status,
        ];

        $invalidRows = $import->rows()->where('status', 'invalid')->orderBy('row_number')->paginate(20);
        $skippedRows = $import->rows()->where('status', 'skipped')->orderBy('row_number')->paginate(20);

        return view('admin.imports.show', compact('import', 'stats', 'invalidRows', 'skippedRows'));
    }

    private function ensureAdmin(): void
    {
        $u = Auth::user();
    }

    private function requiredFieldsForType(string $type): array
    {
        if ($type === 'payments') {
            return [
                'user_email',
                'revenue_item_name',
                'amount',
                'status',
                'paid_at',
                'reference',
            ];
        }

        return [];
    }

    private function suggestedHeaderMap(): array
    {
        return [
            'user_email' => ['email', 'payer email', 'user email'],
            'revenue_item_name' => ['item', 'service', 'revenue item', 'revenue item name'],
            'amount' => ['amount', 'fee', 'paid amount', 'amount paid'],
            'status' => ['status', 'payment status'],
            'paid_at' => ['paid date', 'payment date', 'date', 'date paid'],
            'reference' => ['reference', 'receipt', 'txn', 'transaction', 'transaction id'],
        ];
    }

    private function parseCsvToRows(ImportBatch $batch): int
    {
        $fullPath = Storage::disk('local')->path($batch->stored_path);

        $handle = fopen($fullPath, 'r');
        if (!$handle) {
            throw new \RuntimeException('Unable to read uploaded file');
        }

        $header = null;
        $rowNumber = 0;
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            if ($rowNumber === 1) {
                $header = $this->normalizeHeaders($row);
                continue;
            }

            if (!$header) {
                continue;
            }

            if ($this->isEmptyCsvRow($row)) {
                continue;
            }

            $raw = [];
            foreach ($header as $i => $key) {
                $raw[$key] = isset($row[$i]) ? trim((string) $row[$i]) : null;
            }

            ImportRow::create([
                'import_id' => $batch->id,
                'row_number' => $rowNumber,
                'raw_json' => $raw,
                'status' => 'pending',
            ]);

            $count++;
        }

        fclose($handle);

        return $count;
    }

    private function normalizeHeaders(array $headers): array
    {
        return array_map(function ($h) {
            $h = trim((string) $h);
            $h = mb_strtolower($h);
            $h = preg_replace('/\s+/', ' ', $h);
            return $h;
        }, $headers);
    }

    private function isEmptyCsvRow(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }
        return true;
    }

    private function mapAndValidateRow(string $type, array $raw, array $mapping): array
    {
        $mapped = [];
        $errors = [];

        foreach ($mapping as $field => $header) {
            if (!$header) continue;

            $key = mb_strtolower(trim((string) $header));
            $mapped[$field] = $raw[$key] ?? null;
        }

        if ($type === 'payments') {
            $email = trim((string) ($mapped['user_email'] ?? ''));
            $itemName = trim((string) ($mapped['revenue_item_name'] ?? ''));
            $amount = $mapped['amount'] ?? null;

            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['user_email'] = 'Invalid email';
            } elseif (!User::where('email', $email)->exists()) {
                $errors['user_email'] = 'User not found';
            }

            if ($itemName === '') {
                $errors['revenue_item_name'] = 'Revenue item is required';
            } elseif (!RevenueItem::where('name', $itemName)->exists()) {
                $errors['revenue_item_name'] = 'Revenue item not found';
            }

            if (!is_numeric($amount) || (float) $amount <= 0) {
                $errors['amount'] = 'Amount must be a number greater than 0';
            } else {
                $mapped['amount'] = (float) $amount;
            }

            $status = mb_strtolower(trim((string) ($mapped['status'] ?? 'paid')));
            $allowed = ['pending', 'paid', 'failed', 'reversed'];
            if (!in_array($status, $allowed, true)) {
                $errors['status'] = 'Invalid status';
            }
            $mapped['status'] = $status;

            $ref = trim((string) ($mapped['reference'] ?? ''));
            if ($ref === '') {
                $errors['reference'] = 'Reference is required for dedupe';
            } elseif (Payment::where('reference', $ref)->exists()) {
                $errors['reference'] = 'Duplicate reference already exists';
            }

            $dateRaw = trim((string) ($mapped['paid_at'] ?? ''));
            if ($status === 'paid') {
                if ($dateRaw === '') {
                    $errors['paid_at'] = 'Paid date is required when status is paid';
                } else {
                    try {
                        $mapped['paid_at'] = Carbon::parse($dateRaw)->toDateTimeString();
                    } catch (\Throwable $e) {
                        $errors['paid_at'] = 'Invalid paid date';
                    }
                }
            } else {
                // Not paid: paid_at should be null
                $mapped['paid_at'] = null;
            }
        }

        return [$mapped, $errors];
    }

    private function importPaymentRow(array $payload): string
    {
        $email = trim((string) ($payload['user_email'] ?? ''));
        $itemName = trim((string) ($payload['revenue_item_name'] ?? ''));
        $reference = trim((string) ($payload['reference'] ?? ''));

        // Hard dedupe again (race safe)
        if ($reference !== '' && Payment::where('reference', $reference)->exists()) {
            return 'skipped';
        }

        $user = User::where('email', $email)->first();
        $item = RevenueItem::where('name', $itemName)->first();

        if (!$user || !$item) {
            return 'skipped';
        }

        $status = mb_strtolower(trim((string) ($payload['status'] ?? 'paid')));
        $paidAt = $payload['paid_at'] ?? null;

        Payment::create([
            'user_id' => $user->id,
            'revenue_item_id' => $item->id,
            'amount' => (float) ($payload['amount'] ?? 0),
            'penalty_amount' => 0,
            'status' => $status,
            'payment_method' => (string) ($payload['payment_method'] ?? 'import'),
            'reference' => $reference,
            'collected_by' => Auth::id(),
            'paid_at' => $status === 'paid' ? $paidAt : null,
            'transaction_details' => [
                'source' => 'import',
                'imported_by' => Auth::id(),
            ],
        ]);

        return 'imported';
    }

    private function asArray($value): array
    {
        if (is_array($value)) return $value;

        if (is_object($value)) return (array) $value;

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) return $decoded;
        }

        return [];
    }
}
