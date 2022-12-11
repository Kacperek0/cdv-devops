<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateExpensesTable.
 */
class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('bank_id')->nullable()->constrained('banks')->nullOnDelete();

            $table->string('name');
            $table->integer('amount');
            $table->date('date_at')->index();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->index(['category_id']);
            $table->index(['user_id']);
            $table->index(['bank_id']);
            $table->index(['date_at', 'created_at']);
            $table->index(['user_id', 'date_at', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('expenses');
    }
}
