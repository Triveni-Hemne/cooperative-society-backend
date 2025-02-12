<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcaste extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
}