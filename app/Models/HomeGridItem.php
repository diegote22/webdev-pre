<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeGridItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'title',
        'media_path',
        'media_type'
    ];

    /**
     * URL absoluta al archivo público considerando instalaciones en subcarpetas.
     */
    public function getUrlAttribute(): string
    {
        // request()->getBaseUrl() devuelve p.ej: /Laravel/WebDev-Pre/public cuando no está en raíz
        $base = request()->getBaseUrl();
        return rtrim($base, '/') . '/storage/' . ltrim($this->media_path, '/');
    }
}
