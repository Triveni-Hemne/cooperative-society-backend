<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'voucher_num',
        'token_number',
        'serial_no',
        'date',
        'receipt_id',
        'payment_id',
        'ledger_id',
        'account_id',
        'from_date',
        'to_date',
        'opening_balance',
        'current_balance',
        'narration',
        'm_narration',
        'status',
    ];

    public function ledger()
    {
        return $this->belongsTo(ScheduleLedger::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}