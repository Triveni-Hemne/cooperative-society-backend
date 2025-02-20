<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Agent extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'agent_code', 'commition_rate', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}