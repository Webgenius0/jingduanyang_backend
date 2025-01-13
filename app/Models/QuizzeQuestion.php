<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizzeQuestion extends Model
{

    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'quizze_category_id' => 'integer',
    ];

    protected $hidden = [
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * The quizze category of the question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function quizze_category()
    {
        return $this->belongsTo(QuizzeCategory::class,'quizze_category_id');
    }
}
