<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class RecurringDeposit extends Model
{
     use HasFactory;

    protected $fillable = [
        'deposit_account_id', 'rd_term_months', 'maturity_amount'
    ];

    public function depositAccount() {
        return $this->belongsTo(MemberDepoAccount::class, 'deposit_account_id');
    }
}