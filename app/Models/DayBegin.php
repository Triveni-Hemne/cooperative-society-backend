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
        'status'
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }
}