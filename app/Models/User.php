<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'title',
        'biography',
        'language',
        'website',
        'facebook',
        'instagram',
        'linkedin',
        'tiktok',
        'twitter',
        'youtube',
        'avatar_path',
        'student_group',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Cursos matriculados (alumno)
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')->withTimestamps();
    }

    /**
     * Get the avatar URL for the user.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar_path) {
            return Storage::disk('public')->url($this->avatar_path);
        }
        return null;
    }

    /**
     * Get the user's initials for avatar fallback.
     */
    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
            if (strlen($initials) >= 2) break;
        }
        return $initials ?: 'U';
    }
}
