<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'board_list_id',
        'title',
        'description',
        'list_key',
        'completed',
        'due_date',
        'start_date',
        'labels',
        'members',
        'checklist',
        'attachments',
        'activities',
    ];

    protected $casts = [
        'due_date' => 'date',
        'start_date' => 'date',
        'completed' => 'boolean',
        'labels' => 'array',
        'members' => 'array',
        'checklist' => 'array',
        'attachments' => 'array',
        'activities' => 'array',
    ];

    public function boardList()
    {
        return $this->belongsTo(BoardList::class);
    }
}
