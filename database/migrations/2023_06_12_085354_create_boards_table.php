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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();

            // team or user
            $table->morphs('owner');

            $table->string('name');

            $table->unsignedInteger('sort')->default(0);

            $table->unique(['name', 'owner_type', 'owner_id']);

            $table->date('due_date')->nullable()->default(null);

            $table->date('completed_date')->nullable()->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};
