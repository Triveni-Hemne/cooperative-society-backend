<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Payment extends Model
{
    use HasFactory;

   protected $fillable = [
        'member_id', 'member_depo_account_id', 'account_id', 'member_loan_account_id',
        'amount', 'payment_date', 'method', 'status'
    ];

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function depositAccount() {
        return $this->belongsTo(Account::class, 'member_depo_account_id');
    }

    public function account() {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function loanAccount() {
        return $this->belongsTo(Loan::class, 'member_loan_account_id');
    }
}