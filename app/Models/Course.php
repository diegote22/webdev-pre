<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CourseGoal;
use App\Models\CourseRequirement;

class Course extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category_id',
        'title',
        'slug',
        'description',
        'price',
        'summary',
        'image_path',
        'promo_video_url',
        'level',
    ];

    public function professor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function goals()
    {
        return $this->hasMany(CourseGoal::class);
    }

    public function requirements()
    {
        return $this->hasMany(CourseRequirement::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('position');
    }
}
