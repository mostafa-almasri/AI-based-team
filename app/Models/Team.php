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
       'project_name', 'project_field', 'count_team', 'time_frame', 'manager_id', 'project_skill'
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

}
