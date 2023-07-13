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
        Schema::create('discussion_comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('discussion_id')
                ->references('id')
                ->on('discussions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->text('comment');

            $table->foreignId('created_by')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('updated_by')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('discussion_comments');
    }
};
