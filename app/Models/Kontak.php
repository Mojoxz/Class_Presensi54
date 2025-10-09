<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontak';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'subjek',
        'pesan',
        'is_displayed',
        'is_read'
    ];

    protected $casts = [
        'is_displayed' => 'boolean',
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Scope untuk pesan yang ditampilkan
    public function scopeDisplayed($query)
    {
        return $query->where('is_displayed', true);
    }

    // Scope untuk pesan yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
