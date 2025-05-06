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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_code',50)->unique();
            $table->string('teacher_name',50);
            $table->date('teacher_dob');
            $table->string('teacher_email',100);
            $table->string('teacher_phone',15);
            $table->text('address')->nullable();
            $table->text('teacher_profile')->nullable();
            $table->binary('teacher_image')->nullable();
            $table->timestamps();

            /**
             * make relationship with gender table
             */
            $table->unsignedBigInteger('gender_id');
            $table->foreign('gender_id')
                ->references('id')->on('genders')
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



            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
