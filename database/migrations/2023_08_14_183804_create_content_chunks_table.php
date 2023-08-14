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
        Schema::create('content_chunks', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            // text/image/video/whatever man
            $table->string('type', 50);

            $table->boolean('reusable')->default(true);

            $table->text('content')->nullable()->default(null);

            $table->string('file_location')->nullable()->default(null);

            $table->decimal('current_version', 10,2)->default(0.1);

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
        Schema::dropIfExists('content_chunks');
    }
};