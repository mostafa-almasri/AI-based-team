<?php

namespace App\Models;

use App\Models\Team;
use App\Models\User;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_name',
        'task_duration',
        'start_date',
        'finish_date',
        'team_id',
        'member_id',
        'status',
        'progress'
    ];

    public function member()
    {
        return $this->belongsTo(User::class , 'member_id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class , 'team_id');
    }
    public function document()
    {
        return $this->hasone(Document::class , 'task_id');
    }
}
