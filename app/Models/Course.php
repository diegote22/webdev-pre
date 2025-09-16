<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CourseGoal;
use App\Models\CourseRequirement;
use App\Models\CourseReview;

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
        'status',
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

    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    // Estados posibles: pending, under_review, published, rejected, unpublished
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeUnpublished($query)
    {
        return $query->where('status', 'unpublished');
    }

    // Alumnos inscritos
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')->withTimestamps();
    }

    // Helpers de imagen en disco público
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) return null;
        return Storage::disk('public')->url($this->image_path);
    }

    public function getHasImageAttribute(): bool
    {
        return $this->image_path ? Storage::disk('public')->exists($this->image_path) : false;
    }

    public function getAverageRatingAttribute(): float
    {
        $avg = (float) ($this->reviews()->avg('rating') ?? 0);
        return round($avg, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return (int) ($this->reviews()->count());
    }
}
