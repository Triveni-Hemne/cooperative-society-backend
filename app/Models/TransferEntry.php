<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TransferEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type', 'date', 'receipt_id', 'payment_id', 
        'ledger_id', 'opening_balance', 'current_balance', 'narration', 'm_narration', 'created_by'
    ];

    public function ledger() {
        return $this->belongsTo(GeneralLedger::class);
    }
    public function user()
    {
        return $this->hasOne(User::class, 'created_by');
    }
}