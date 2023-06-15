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
        Schema::create('photos_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photos_id')->constrained('photos')->onDelete('cascade');
            $table->string('tags'); // 1. Likes 2. Dislike
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos_tags');
    }
};
