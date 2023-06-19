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
        Schema::create('board_project', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->references('id')
                ->on('projects')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('board_id')
                ->references('id')
                ->on('boards')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedInteger('sort')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_project');
    }
};
