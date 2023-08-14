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
        Schema::create('article_content_chunk', function (Blueprint $table) {
            $table->id();

            $table->foreignId('article_id')
                ->references('id')
                ->on('articles')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('content_chunk_id')
                ->references('id')
                ->on('content_chunks')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_content_chunk');
    }
};
