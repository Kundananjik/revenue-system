<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportRow extends Model
{
    protected $fillable = [
        'import_id','row_number','raw_json','mapped_json','status','errors_json',
    ];

    protected $casts = [
        'raw_json' => 'array',
        'mapped_json' => 'array',
        'errors_json' => 'array',
    ];

    public function batch()
    {
        return $this->belongsTo(ImportBatch::class, 'import_id');
    }
}
