<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Subdivision extends Model
{
     use HasFactory;

    protected $fillable = [
        'division_id', 'name', 'naav', 'address', 'description'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}