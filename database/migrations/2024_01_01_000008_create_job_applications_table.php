<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // applicant
            $table->text('cover_letter')->nullable();
            $table->string('resume_path')->nullable(); // snapshot of CV used for this application
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'interview', 'rejected', 'hired'])->default('pending')->index();
            $table->text('employer_note')->nullable();
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamps();

            $table->unique(['job_id', 'user_id']); // one application per job per user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
