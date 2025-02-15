<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InterestLedger extends Model
{
    use HasFactory;

    protected $table = 'interest_ledger';

    protected $fillable = [
        'general_ledger_id',
        'transaction_id',
        'interest_rate',
        'amount',
        'interest_applied_date'
    ];

    public function generalLedger()
    {
        return $this->belongsTo(GeneralLedger::class, 'general_ledger_id');
    }

    public function transaction()
    {
        return $this->belongsTo(InstallmentTransaction::class, 'transaction_id');
    }
}