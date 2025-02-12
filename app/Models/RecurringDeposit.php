<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringDeposit extends Model
{
     use HasFactory;

    protected $fillable = [
        'deopsite_account_id',
        'rd_term_months',
        'maturity_amount',
    ];

    public function depositAccount()
    {
        return $this->belongsTo(MemberDepoAccount::class, 'deopsite_account_id');
    }
}