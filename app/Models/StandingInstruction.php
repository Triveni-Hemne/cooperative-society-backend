<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class StandingInstruction extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_ledger_id',
        'credit_account_id',
        'credit_transfer',
        'debit_ledger_id',
        'debit_account_id',
        'debit_transfer',
        'date',
        'frequency',
        'no_of_times',
        'bal_installment',
        'execution_date',
        'amount',
        'created_by',
        'branch_id'
    ];

    public function creditLedger() {
        return $this->belongsTo(GeneralLedger::class, 'credit_ledger_id');
    }

    public function creditAccount() {
        return $this->belongsTo(Account::class, 'credit_account_id');
    }

    public function debitLedger() {
        return $this->belongsTo(GeneralLedger::class, 'debit_ledger_id');
    }

    public function debitAccount() {
        return $this->belongsTo(Account::class, 'debit_account_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}