<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
	protected $fillable = ['category_id', 'name', 'slug'];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function courses()
	{
		return $this->hasMany(Course::class, 'sub_category_id');
	}
}
