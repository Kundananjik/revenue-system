<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action'); // e.g., "created payment"
            $table->string('auditable_type'); // e.g., App\Models\Payment
            $table->unsignedBigInteger('auditable_id')->nullable(); // e.g., payment ID
            $table->json('old_values')->nullable(); // previous data
            $table->json('new_values')->nullable(); // new data
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['auditable_type', 'auditable_id']); // index for faster queries
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
};
