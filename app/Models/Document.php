<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'document',
        'team_id',
        'member_id',
        'task_id',
        'progress_update'
    ];

    public function member()
    {
        return $this->belongsTo(User::class , 'member_id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class , 'team_id');
    }
    public function task()
    {
        return $this->belongsTo(Task::class , 'task_id');
    }
}
