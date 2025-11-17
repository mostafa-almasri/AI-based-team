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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document')->nullable();
            $table->integer('progress_update'); // نسبة التقدم المضافة
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade'); 
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade'); 
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
