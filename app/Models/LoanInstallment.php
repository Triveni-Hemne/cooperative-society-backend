<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LoanInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'installment_type',
        'mature_date',
        'first_installment_date',
        'total_installments',
        'installment_amount',
        'installment_with_interest',
        'total_installments_paid',
    ];

    public function loan()
    {
        return $this->belongsTo(MemberLoanAccount::class, 'loan_id');
    }
}