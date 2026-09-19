<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('knowledge_article_id')
                ->nullable()
                ->constrained('knowledge_articles')
                ->nullOnDelete();

            $table->text('question');

            $table->text('answer');

            $table->unsignedInteger('match_score')
                ->default(0);

            $table->boolean('found_answer')
                ->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_questions');
    }
};