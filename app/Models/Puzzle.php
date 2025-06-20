<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Puzzle extends Model
{
    use HasFactory;

    protected $fillable = [
        'fen',
        'solution',
        'difficulty',
        'plays_first',
        'castling_rights',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
