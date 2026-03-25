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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('job_vacancy_id');
            $table->uuid('resume_id');
            $table->uuid("user_id");
            $table->float('aiGeneratedScore', 2)->default(0);
            $table->longText('aiGeneratedFeedback')->nullable();
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
            //Relationships
            $table->foreign('job_vacancy_id')->references('id')->on('job_vacancies')->onDelete('cascade');
            $table->foreign('resume_id')->references('id')->on('resumes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
