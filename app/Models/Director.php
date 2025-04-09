<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Director extends Model
{
     use HasFactory;

    protected $fillable = [
        'member_id', 'name', 'email', 'contact_nos',
        'designation_id', 'status', 'from_date', 'to_date'
    ];

    protected $casts = [
        'contact_nos' => 'array',
    ];

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function designation() {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
}