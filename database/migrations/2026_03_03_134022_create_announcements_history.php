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
        Schema::create('announcement_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_history_id')->constrained('user_histories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('course_history_id')->constrained('course_histories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title',100);
            $table->string('message',100)->nullable();
            $table->text('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcement_histories');
    }
};
