<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('type')->index(); // payments, revenue_items, users
            $table->enum('status', ['uploaded','mapped','previewed','importing','completed','failed'])
                ->default('uploaded')
                ->index();

            $table->string('original_filename');
            $table->string('stored_path');

            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('valid_rows')->default(0);
            $table->unsignedInteger('invalid_rows')->default(0);
            $table->unsignedInteger('imported_rows')->default(0);
            $table->unsignedInteger('skipped_rows')->default(0);

            $table->json('mapping_json')->nullable();
            $table->json('summary_json')->nullable();
            $table->text('error_message')->nullable();

            $table->timestamps();

            $table->index(['created_by', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('imports');
    }
};
