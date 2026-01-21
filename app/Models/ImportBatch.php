<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportBatch extends Model
{
    protected $table = 'imports';

    protected $fillable = [
        'created_by','type','status','original_filename','stored_path',
        'total_rows','valid_rows','invalid_rows','imported_rows','skipped_rows',
        'mapping_json','summary_json','error_message',
    ];

    protected $casts = [
        'mapping_json' => 'array',
        'summary_json' => 'array',
    ];

    public function rows()
    {
        return $this->hasMany(ImportRow::class, 'import_id');
    }
}
