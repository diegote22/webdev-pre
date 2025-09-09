<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTopic extends Model
{
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
