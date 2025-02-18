<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class BankInvestment extends Model
{
    use HasFactory;

    protected $fillable = [
        'deopsite_account_id',
        'fd_term_months',
        'maturity_amount',
    ];

   public function depositAccount()
    {
        return $this->belongsTo(MemberDepoAccount::class, 'deopsite_account_id');
    }
}