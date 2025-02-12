<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanResolutionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'resolution_no',
        'resolution_date',
    ];

    public function loan()
    {
        return $this->belongsTo(MemberLoanAccount::class, 'loan_id');
    }
}