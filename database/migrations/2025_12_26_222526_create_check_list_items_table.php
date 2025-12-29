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
        Schema::create('check_list_items', function (Blueprint $table) {
            $table->id();
            $table->morphs('nota'); 
            
            $table->string('section_id');
            $table->integer('task_index'); 
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            $table->unique(['nota_id', 'nota_type', 'section_id', 'task_index'], 'unique_task_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_list_items');
    }
};
