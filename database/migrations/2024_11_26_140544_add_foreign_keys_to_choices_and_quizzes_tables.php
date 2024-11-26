<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Tambahkan foreign key pada tabel 'choices'
        Schema::table('choices', function (Blueprint $table) {
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
        });
    
        // Tambahkan foreign key pada tabel 'quizzes'
        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreign('correct_choice_id')->references('id')->on('choices')->onDelete('set null');
        });
    }
    
    public function down()
    {
        // Hapus foreign key pada tabel 'choices'
        Schema::table('choices', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
        });
    
        // Hapus foreign key pada tabel 'quizzes'
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['correct_choice_id']);
        });
    }
    
};
