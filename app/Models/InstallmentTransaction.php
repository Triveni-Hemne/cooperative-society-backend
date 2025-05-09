<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InstallmentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_account_id', 'installment_no', 'amount_paid',
        'payment_date', 'interest_earned', 'total_balance','created_by'
    ];

    public function depositAccount() {
        return $this->belongsTo(MemberDepoAccount::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}