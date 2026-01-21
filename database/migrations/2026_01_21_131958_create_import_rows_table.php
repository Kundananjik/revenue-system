<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('import_rows', function (Blueprint $table) {
            $table->id();

            $table->foreignId('import_id')
                ->constrained('imports')
                ->cascadeOnDelete();

            $table->unsignedInteger('row_number');

            $table->json('raw_json');
            $table->json('mapped_json')->nullable();
            $table->json('errors_json')->nullable();

            $table->enum('status', ['pending','valid','invalid','imported','skipped'])
                ->default('pending')
                ->index();

            $table->timestamps();

            $table->index(['import_id', 'row_number']);
            $table->index(['import_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('import_rows');
    }
};
