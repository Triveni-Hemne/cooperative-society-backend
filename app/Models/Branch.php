<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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