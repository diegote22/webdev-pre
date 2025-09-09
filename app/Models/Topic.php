<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function subTopics()
    {
        return $this->hasMany(SubTopic::class);
    }
}
