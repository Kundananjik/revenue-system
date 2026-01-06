<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenueItemsTable extends Migration
{
    public function up(): void
    {
        Schema::create('revenue_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('revenue_categories')->onDelete('cascade');
            $table->string('code', 50)->nullable();
            $table->string('name', 255)->unique();
            $table->text('description')->nullable();
            $table->string('calculation_type'); // matches your controller validation
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('payment_frequency'); 
            $table->decimal('penalty_rate', 8, 4)->default(0);
            $table->json('metadata')->nullable(); // Cast as array in model
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revenue_items');
    }
}