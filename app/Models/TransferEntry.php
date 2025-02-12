<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'date',
        'receipt_id',
        'payment_id',
        'ledger_id',
        'opening_balance',
        'current_balance',
        'narration',
        'm_narration',
    ];

    public function ledger()
    {
        return $this->belongsTo(ScheduleLedger::class);
    }
}