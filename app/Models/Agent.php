<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agent_code',
        'commition_rate',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}