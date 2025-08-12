<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Employee extends Model
{
   use HasFactory;

    protected $fillable = [
        'emp_code', 'designation_id', 'salary', 'other_allowance',
        'division_id', 'subdivision_id', 'center_id', 'joining_date', 
        'transfer_date', 'retirement_date', 'gpf_no', 'hra', 'da', 
    ];

    public function member()
    {
        return $this->hasOne(Member::class, 'employee_id');
    }
    public function designation() {
        return $this->belongsTo(Designation::class);
    }

    public function division() {
        return $this->belongsTo(Division::class);
    }

    public function subdivision() {
        return $this->belongsTo(Subdivision::class);
    }

    // public function center() {
    //     return $this->belongsTo(Center::class);
    // }
     public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }
}