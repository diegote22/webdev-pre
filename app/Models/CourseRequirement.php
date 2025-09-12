<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
	protected $fillable = ['course_id', 'text', 'position'];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}
}
