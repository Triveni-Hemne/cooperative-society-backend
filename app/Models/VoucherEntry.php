<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class VoucherEntry extends Model
{
    use HasFactory;

   protected $fillable = [
        'transaction_type', 'voucher_num', 'token_number', 'serial_no', 'date', 
        'receipt_id', 'payment_id', 'ledger_id', 'account_id', 
        'member_depo_account_id', 'member_loan_account_id', 'from_date', 'to_date', 
        'opening_balance', 'current_balance', 'narration', 'm_narration', 'status'
    ];

    public function ledger() {
        return $this->belongsTo(Ledger::class);
    }

    public function account() {
        return $this->belongsTo(Account::class);
    }

    public function memberDepositAccount() {
        return $this->belongsTo(MemberAccount::class, 'member_depo_account_id');
    }

    public function memberLoanAccount() {
        return $this->belongsTo(MemberLoanAccount::class, 'member_loan_account_id');
    }
}