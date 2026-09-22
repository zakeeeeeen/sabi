<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('step_key'); // e.g. 'ide_bisnis', 'game_belanja', 'hitung_modal', 'studi_kasus_tabungan', 'studi_kasus_investasi'
            $table->json('payload')->nullable();
            $table->text('answer_text')->nullable();
            $table->timestamps();
        });

        Schema::create('spending_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->string('category')->default('produksi'); // produksi / promosi
            $table->boolean('is_correct')->default(false);
            $table->integer('order_num')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spending_items');
        Schema::dropIfExists('student_submissions');
    }
};
