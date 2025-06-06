<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nominee extends Model
{
   use HasFactory;

   protected $fillable = [
        'nominee_id',
        'member_id',
        'depo_acc_id',
        'loan_acc_id',
        'nominee_name',
        'nominee_naav',
        'nominee_age',
        'nominee_gender',
        'relation',
        'nominee_image',
        'nominee_signature',
        'nominee_address',
        'nominee_marathi_address',
        'nominee_adhar_no'
    ];

   /**
     * Get the member who is the nominee.
     */
    public function nomineeMember()
    {
        return $this->belongsTo(Member::class, 'nominee_id');
    }

    /**
     * Get the member who owns this nominee.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /**
     * Get the deposit account associated with this nominee.
     */
    public function depositAccount()
    {
        return $this->belongsTo(MemberDepoAccount::class, 'depo_acc_id');
    }

    public function loanAccount()
    {
        return $this->belongsTo(MemberLoanAccount::class, 'loan_acc_id');
    }
}