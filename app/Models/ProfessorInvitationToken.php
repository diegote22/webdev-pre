<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessorInvitationToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'note',
        'expires_at',
        'used_at',
        'used_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function usedByUser()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public function scopeUnused($query)
    {
        return $query->whereNull('used_at')->whereNull('used_by');
    }

    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
        });
    }
}
