<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DayBegin extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'member_id',
        'status',
        'created_by'
    ];

    public function member() {
        return $this->belongsTo(Member::class, 'member_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}