<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategory;
use App\Models\Course;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
