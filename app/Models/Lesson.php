<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'title',
        'description',
        'video_type',
        'video_url',
        'thumbnail_path',
        'is_published',
        'is_preview',
        'position',
        'duration',
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
