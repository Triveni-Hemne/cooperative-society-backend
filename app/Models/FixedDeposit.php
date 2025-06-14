<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FixedDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_account_id', 'fd_term_months', 'maturity_amount', 'slip_no'
    ];

    public function depositAccount() {
        return $this->belongsTo(DepositAccount::class);
    }
}