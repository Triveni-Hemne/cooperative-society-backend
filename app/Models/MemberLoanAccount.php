<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MemberLoanAccount extends Model
{
  use HasFactory;

    protected $fillable = [
        'ledger_id', 'member_id','images', 'account_id', 'acc_no', 'loan_type', 'name',
        'ac_start_date', 'open_balance', 'purpose', 'principal_amount', 'interest_rate',
        'tenure', 'emi_amount', 'start_date', 'end_date', 'balance', 'priority',
        'loan_amount', 'collateral_type', 'collateral_value', 'status', 'add_to_demand',
        'is_loss_asset', 'case_flag', 'page_no', 'interest', 'postage', 'insurance',
        'open_interest', 'penal_interest', 'notice_fee', 'insurance_date'
    ];

    public function ledger() {
        return $this->belongsTo(GeneralLedger::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function account() {
        return $this->belongsTo(Account::class);
    }

    public function nominees()
    {
        return $this->hasMany(Nominee::class, 'loan_acc_id');
    }

    public function goldLoanDtl()
    {
        return $this->hasOne(GoldLoanDetail::class, 'loan_id'); 
    }

     public function loanGarantor()
    {
        return $this->hasOne(LoanGuarantor::class, 'loan_id'); 
    }

     public function loanInstallments()
    {
        return $this->hasMany(LoanInstallment::class, 'loan_id'); 
    }

     public function loanResolutionDtl()
    {
        return $this->hasOne(LoanResolutionDetail::class, 'loan_id'); 
    }


    /**
     * Accessors & Mutators (if needed)
     */
    
    // Convert open balance to float
    public function getOpenBalanceAttribute($value)
    {
        return (float) $value;
    }

    // Convert balance to float
    public function getBalanceAttribute($value)
    {
        return (float) $value;
    }

    // Convert interest rate to float
    public function getInterestRateAttribute($value)
    {
        return (float) $value;
    }
}