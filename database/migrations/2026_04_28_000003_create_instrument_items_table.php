<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_items', function (Blueprint $table) {
            $table->id();
            $table->string('page_slug');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('model_path');
            $table->unsignedInteger('position');
            $table->timestamps();

            $table->unique(['page_slug', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_items');
    }
};
