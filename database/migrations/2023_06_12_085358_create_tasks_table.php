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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->foreignId('project_id')
                ->references('id')
                ->on('projects')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('checklist_id')
                ->nullable()
                ->default(null)
                ->references('id')
                ->on('checklists')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedInteger('sort')->default(0);

            $table->foreignId('assigned_to')
                ->nullable()
                ->default(null)
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->date('due_date')->nullable()->default(null);

            $table->date('completed_date')->nullable()->default(null);

            $table->foreignId('completed_by')
                ->nullable()
                ->default(null)
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
