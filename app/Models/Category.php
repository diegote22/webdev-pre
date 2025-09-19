<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SubCategory;
use App\Models\Course;

class Category extends Model
{
    use HasFactory;
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
