<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['cron', 'queue']);
            $table->string('subject');
            $table->text('email_content');
            $table->text('email_addresses'); // comma-separated
            $table->integer('total_sends')->default(2);
            $table->integer('sent_count')->default(0);
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};