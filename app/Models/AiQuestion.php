<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'knowledge_article_id',
        'question',
        'answer',
        'match_score',
        'found_answer',
    ];

    protected function casts(): array
    {
        return [
            'found_answer' => 'boolean',
            'match_score' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function knowledgeArticle()
    {
        return $this->belongsTo(
            KnowledgeArticle::class
        );
    }
}