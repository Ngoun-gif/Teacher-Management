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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code', 10)->unique();
            $table->string('course_name', 50);
            $table->string('syllabus');
            $table->integer('duration');
            $table->decimal('course_price', 10,2);
            $table->timestamps();
            /**
             * make relationship with major table
             */
            $table->unsignedBigInteger('major_id');
            $table->foreign('major_id')
                ->references('id')->on('majors')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
