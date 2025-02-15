<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MemberDepoAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'ledger_id',
        'member_id',
        'acc_no',
        'name',
        'interest_rate',
        'ac_start_date',
        'open_balance',
        'balance',
        'closing_flag',
        'add_to_demand',
        'agent_id',
        'page_no',
        'installment_type',
        'installment_amount',
        'total_installments',
        'total_payable_amount',
        'total_installments_paid',
        'account_closing_date',
        'interest_payable',
        'open_interest',
    ];

    public function ledger()
    {
        return $this->belongsTo(GeneralLedger::class, 'ledger_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}