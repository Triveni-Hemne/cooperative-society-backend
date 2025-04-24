<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DayEnd extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'opening_cash', 'total_credit_rs', 
        'total_credit_chalans', 'total_debit_rs', 'total_debit_challans', 'created_by'
    ];

    protected $casts = [
        'date' => 'date',
    ];

     public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
     public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}