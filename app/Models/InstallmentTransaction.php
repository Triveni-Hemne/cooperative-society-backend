<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_account_id',
        'installment_no',
        'amount_paid',
        'payment_date',
        'interest_earned',
        'total_balance',
    ];

    public function depositAccount()
    {
        return $this->belongsTo(MemberDepoAccount::class, 'deposit_account_id');
    }
}