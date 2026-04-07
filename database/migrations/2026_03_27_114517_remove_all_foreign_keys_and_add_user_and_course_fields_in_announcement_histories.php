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
        Schema::table('announcement_histories', function (Blueprint $table) {
            $table->dropForeign(['user_history_id']);
            $table->dropForeign(['course_history_id']);
            $table->dropColumn(['user_history_id', 'course_history_id']);
            $table->string('user',100)->after('id');
            $table->string('course',100)->after('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcement_histories', function (Blueprint $table) {
            $table->foreignId('user_history_id')->constrained('user_histories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('course_history_id')->constrained('course_histories')->onUpdate('cascade')->onDelete('cascade');
            $table->dropColumn(['user', 'course']);
        });
    }
};
