<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class GeneralLedger extends Model
{
    use HasFactory;

    protected $fillable = [
       'parent_ledger_id',
        'ledger_no',
        'name',
        'balance',
        'balance_type',
        'open_balance',
        'open_balance_type',
        'min_balance',
        'min_balance_type',
        'interest_rate',
        'add_interest_to_balance',
        'open_date',
        'penal_rate',
        'gl_type',
        'cd_ratio',
        'group',
        'type_detail',
        'interest_type',
        'subsidiary',
        'demand',
        'send_sms',
        'item_of',
    ];

    public function parentLedger() {
        return $this->belongsTo(GeneralLedger::class, 'parent_ledger_id');
    }
}