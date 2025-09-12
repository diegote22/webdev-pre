<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'section_id',
        'title',
        'description',
        'video_type',
        'video_url',
        'thumbnail_path',
        'is_published',
        'is_preview',
        'position'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function attachments()
    {
        return $this->hasMany(LessonAttachment::class);
    }
}
