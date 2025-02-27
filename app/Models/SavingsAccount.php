<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavingsAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_account_id', 'balance', 'interest_rate', 'status'
    ];

    public function depositAccount() {
        return $this->belongsTo(DepositAccount::class);
    }
}