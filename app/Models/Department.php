<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Department extends Model
{
   use HasFactory;

    protected $fillable = [
        'name',
        'head_id',
    ];

    public function head()
    {
        return $this->belongsTo(Employee::class, 'head_id');
    }
}