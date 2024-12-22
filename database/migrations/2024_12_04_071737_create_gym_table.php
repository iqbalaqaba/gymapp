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
        Schema::create('gym', function (Blueprint $table) {
            $table->id();

            $table->string('thumbnail');
            $table->string('name');
            $table->string('slug');
            $table->string('address');
            $table->string('about');
            $table->string('is_popular');
            $table->string('open_time_at');
            $table->string('closed_time_at');
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gyms');
    }
};
