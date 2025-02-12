<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberBankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'bank_name',
        'branch_name',
        'ifsc_code',
        'bank_account_no',
        'proof_1_no',
        'proof_1_type',
        'proof_2_no',
        'proof_2_type',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}