<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonAttachment extends Model
{
    protected $fillable = [
        'lesson_id',
        'path',
        'name',
        'size',
        'mime'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
