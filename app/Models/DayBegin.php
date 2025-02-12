<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayBegin extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}