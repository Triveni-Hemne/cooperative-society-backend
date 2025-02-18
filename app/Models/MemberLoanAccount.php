<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MemberLoanAccount extends Model
{
  use HasFactory;

    protected $fillable = [
        'ledger_id',
        'member_id',
        'acc_no',
        'name',
        'ac_start_date',
        'open_balance',
        'purpose',
        'interest_rate',
        'balance',
        'priority',
        'loan_amount',
        'guarantor1_id',
        'guarantor2_id',
        'guarantor3_id',
        'close_flag',
        'add_to_demand',
        'is_loss_asset',
        'case_flag',
        'page_no',
        'interest',
        'postage',
        'insurance',
        'open_interest',
        'penal_interest',
        'notice_fee',
        'insurance_date',
    ];

    /**
     * Relationships
     */
    
    // Belongs to General Ledger
    public function ledger()
    {
        return $this->belongsTo(GeneralLedger::class);
    }

    // Belongs to Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Guarantors (nullable)
    public function guarantor1()
    {
        return $this->belongsTo(Member::class, 'guarantor1_id');
    }

    public function guarantor2()
    {
        return $this->belongsTo(Member::class, 'guarantor2_id');
    }

    public function guarantor3()
    {
        return $this->belongsTo(Member::class, 'guarantor3_id');
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