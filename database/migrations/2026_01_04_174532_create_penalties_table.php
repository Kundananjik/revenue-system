<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('revenue_item_id')
                  ->constrained('revenue_items')
                  ->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()
                  ->constrained('payments')->nullOnDelete();
            $table->decimal('amount', 15, 2);
            $table->decimal('rate', 8, 4)->nullable();
            $table->string('reason')->nullable();
            $table->timestamp('applied_at')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamps();

            $table->index(['is_paid','applied_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('penalties');
    }
};
