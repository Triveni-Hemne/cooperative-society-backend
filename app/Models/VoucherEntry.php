<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class VoucherEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type', 'voucher_num', 'token_number', 'serial_no', 'date',
        'receipt_id', 'payment_id', 'ledger_id', 'account_id', 'member_depo_account_id',
        'member_loan_account_id', 'amount', 'debit_amount', 'credit_amount',
        'opening_balance', 'current_balance', 'transaction_mode', 'payment_mode',
        'reference_number', 'is_reversed', 'approved_by', 'approved_at', 'entered_by',
        'branch_id', 'to_date', 'from_date', 'narration', 'm_narration', 'status','member_id',
        'cheque_no','balance','interest','penal','post_court','insurance','notice_fee',
        'other','trans_chargs','int_payable','penal_interest','total_amount','int_paid',
    ];

    public function ledger() {
        return $this->belongsTo(GeneralLedger::class);
    }

    public function account() {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function memberDepositAccount() {
        return $this->belongsTo(MemberDepoAccount::class, 'member_depo_account_id');
    }

    public function memberLoanAccount() {
        return $this->belongsTo(MemberLoanAccount::class, 'member_loan_account_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}