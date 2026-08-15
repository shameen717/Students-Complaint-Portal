<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 'student' or 'admin'
            $table->string('role')->default('student')->after('email');
            // university roll number, only required for students
            $table->string('roll_number')->nullable()->unique()->after('role');
            $table->string('department')->nullable()->after('roll_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'roll_number', 'department']);
        });
    }
};
