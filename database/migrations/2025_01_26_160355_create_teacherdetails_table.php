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
        Schema::create('teacherdetails', function (Blueprint $table) {
            $table->id();

            /**
             * make relationship Teachers table
             */
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')
                ->references('id')->on('teachers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            /**
             * make relationship schedule table
             */
            $table->unsignedBigInteger('schedule_id');
            $table->foreign('schedule_id')
                ->references('id')->on('schedules')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            /**
             * make relationship major table
             */
            $table->unsignedBigInteger('major_id');
            $table->foreign('major_id')
                ->references('id')->on('majors')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            /**
             * make relationship course table
             */
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            /**
             * make relationship subject table
             */
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')
                ->references('id')->on('subjects')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table ->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacherdetails');
    }
};
