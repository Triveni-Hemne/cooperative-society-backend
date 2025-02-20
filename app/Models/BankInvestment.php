<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class BankInvestment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ledger_id',
        'account_id',
        'depo_account_id',
        'name',
        'investment_type',
        'interest_rate',
        'opening_date',
        'opening_balance',
        'current_balance',
        'maturity_date',
        'deposit_term_days',
        'months',
        'years',
        'fd_amount',
        'monthly_deposit',
        'rd_term_months',
        'maturity_amount',
        'interest',
        'interest_receivable',
        'interest_frequency'
    ];

    public function ledger() {
        return $this->belongsTo(Ledger::class);
    }

    public function account() {
        return $this->belongsTo(Account::class);
    }

    public function depositAccount() {
        return $this->belongsTo(DepositAccount::class, 'depo_account_id');
    }
}