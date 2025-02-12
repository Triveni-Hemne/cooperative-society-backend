<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subdivision extends Model
{
     use HasFactory;

    protected $fillable = [
        'division_id',
        'name',
        'address',
        'description',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}