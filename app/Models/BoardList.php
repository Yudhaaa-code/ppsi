<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'position',
    ];

    public function cards()
    {
        return $this->hasMany(BoardCard::class)->orderBy('created_at'); // or position if we add it to cards
    }
}
