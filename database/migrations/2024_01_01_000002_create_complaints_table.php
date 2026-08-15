<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            // Human-friendly unique complaint ID, e.g. CMP-2026-000123 (FR006)
            $table->string('complaint_code')->unique();

            // Nullable so anonymous complaints don't store the student's identity (FR003 / FR004)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_anonymous')->default(false);

            $table->string('title');
            $table->enum('category', [
                'academics',
                'faculty_behavior',
                'hostel',
                'fees',
                'results',
                'harassment',
                'infrastructure',
                'other',
            ]);
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');

            // FR012: status lifecycle
            $table->enum('status', ['pending', 'in_progress', 'resolved', 'rejected'])->default('pending');

            $table->string('attachment_path')->nullable();

            // Admin handling fields
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('admin_remarks')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
