<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MemberDepoAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'ledger_id', 'images', 'account_id', 'member_id', 'acc_no', 'deposit_type',
        'name', 'interest_rate', 'ac_start_date', 'open_balance', 'balance',
        'closing_flag', 'add_to_demand', 'agent_id', 'page_no',
        'installment_type', 'installment_amount', 'total_installments',
        'total_payable_amount', 'total_installments_paid', 'acc_closing_date',
        'interest_payable', 'open_interest'
    ];

    public function member() {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function ledger() {
        return $this->belongsTo(GeneralLedger::class, 'ledger_id');
    }

    public function account() {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function recurringDeposit() {
        return $this->hasOne(RecurringDeposit::class, 'deposit_account_id');
    }

    public function fixedDeposit()
    {
        return $this->hasOne(FixedDeposit::class, 'deposit_account_id'); 
    }

    public function saveDeposit()
    {
        return $this->hasOne(SavingsAccount::class, 'deposit_account_id'); 
    }

    public function nominees()
    {
        return $this->hasMany(Nominee::class, 'depo_acc_id');
    }
}