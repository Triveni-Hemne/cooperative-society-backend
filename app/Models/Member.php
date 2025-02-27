<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'subcaste_id', 'name', 'dob', 'gender', 'age',
        'date_of_joining', 'religion', 'category', 'caste', 'm_reg_no',
        'pan_no', 'status'
    ];

    public function subcaste() {
        return $this->belongsTo(Subcaste::class, 'subcaste_id');
    }
}