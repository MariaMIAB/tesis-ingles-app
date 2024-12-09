<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->enum('type', ['multiple_choice', 'true_false', 'short_answer']);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('questions');
    }

};
