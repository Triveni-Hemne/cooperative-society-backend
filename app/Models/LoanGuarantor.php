<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanGuarantor extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'member_id',
        'guarantor_type',
        'status',
        'added_on',
        'released_on',
    ];

    public function loan()
    {
        return $this->belongsTo(MemberLoanAccount::class, 'loan_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}