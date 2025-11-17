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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name')->nullable();
            $table->integer('task_duration')->nullable();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->string('status')->default('In progress');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade'); 
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade'); 
            $table->integer('progress')->default(0); // نسبة الإنجاز من 0% إلى 100%
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
