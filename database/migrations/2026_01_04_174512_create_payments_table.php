<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->foreignId('revenue_item_id')
                  ->constrained('revenue_items')
                  ->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->decimal('penalty_amount', 15, 2)->default(0);
            $table->enum('status', ['pending','paid','failed','reversed'])
                  ->default('pending')->index();
            $table->string('payment_method')->nullable();
            $table->string('reference')->nullable()->unique();
            $table->foreignId('collected_by')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->json('transaction_details')->nullable();
            $table->timestamps();

            $table->index(['user_id','revenue_item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
