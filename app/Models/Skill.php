<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'skill',
        'previous_record',
        'member_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'member_id');
    }
}
