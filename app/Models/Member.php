<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'emp_ac_id',
        'department_id',
        'name',
        'dob',
        'gender',
        'age',
        'date_of_joining',
        'religion',
        'category',
        'caste',
        'm_reg_no',
        'pan_no',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_ac_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}