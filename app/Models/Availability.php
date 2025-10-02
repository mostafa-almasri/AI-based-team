<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Availability extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'is_available',

    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}
