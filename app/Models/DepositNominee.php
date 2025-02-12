<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositNominee extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_account_id',
        'name',
        'age',
        'gender',
        'relation',
        'nominee_image',
    ];

    public function depositAccount()
    {
        return $this->belongsTo(MemberDepoAccount::class, 'deposit_account_id');
    }
}