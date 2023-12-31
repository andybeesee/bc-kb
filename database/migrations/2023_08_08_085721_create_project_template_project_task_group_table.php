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
        Schema::create('project_template_checklist_template', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('project_template_id');
            $table->foreign('project_template_id', 'pj_template_fk')
                ->references('id')
                ->on('project_templates')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('checklist_template_id');
            $table->foreign('checklist_template_id', 'pj_cl_template_fk')
                ->references('id')
                ->on('checklist_templates')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('sort')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_template_checklist_template');
    }
};
