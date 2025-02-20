<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'ledger_id', 'member_id', 'account_no', 'account_name', 'name',
        'account_type', 'interest_rate', 'start_date', 'open_balance', 'balance',
        'closing_flag', 'add_to_demand', 'agent_id', 'installment_type',
        'installment_amount', 'total_installments_paid', 'closing_date'
    ];

    public function ledger() {
        return $this->belongsTo(GeneralLedger::class, 'ledger_id');
    }

    public function member() {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function agent() {
        return $this->belongsTo(Member::class, 'agent_id');
    }
}