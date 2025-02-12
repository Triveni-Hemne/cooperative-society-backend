<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function ledger()
    {
        return $this->belongsTo(GeneralLedger::class, 'ledger_id');
    }

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
}