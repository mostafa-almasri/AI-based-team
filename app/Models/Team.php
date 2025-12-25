<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
       'project_name', 'project_field', 'count_team', 'time_frame', 'manger_id', 'project_skill'
    ];

    protected $casts = [
        'project_skill' => 'array',
    ];

    public function manger()
    {
        return $this->belongsTo(User::class , 'manger_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'team_id');
    }
    public function projectProgress()
    {
        if ($this->tasks->count() == 0) {
            return 0;
        }
    
        return round($this->tasks->avg('progress'));
    }
    public function totalTasks()
{
    return $this->tasks->count();
}

public function completedTasks()
{
    return $this->tasks->where('status', 'completed')->count();
}

public function taskProgress()
{
    if ($this->totalTasks() == 0) return 0; 
    return round(($this->completedTasks() / $this->totalTasks()) * 100);
}
public function members()
{
    return $this->hasManyThrough(
        User::class,
        Task::class,
        'team_id',     // مفتاح Team داخل tasks
        'id',          // مفتاح User
        'id',          // مفتاح Team
        'member_id'    // مفتاح user داخل tasks
    )->distinct();
}
}
