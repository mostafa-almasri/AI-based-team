<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressHistory extends Model
{
    protected $table = 'progress_history';
    use HasFactory;
    protected $fillable = ['task_id','progress','recorded_at'];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
