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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();

            $table->text('description')->nullable()->default(null);

            $table->string('status')->default('incomplete');

            $table->date('due_date')->nullable()->default(null);

            $table->date('completed_date')->nullable()->default(null);

            $table->foreignId('owner_id')
                ->nullable()
                ->default(null)
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('team_id')
                ->nullable()
                ->default(null)
                ->references('id')
                ->on('teams')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
