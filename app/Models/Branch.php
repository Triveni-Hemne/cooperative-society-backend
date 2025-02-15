<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Branch extends Model
{
     use HasFactory;

    protected $fillable = [
        'branch_code',
        'name',
        'location',
        'manager_id'
    ];

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }
}