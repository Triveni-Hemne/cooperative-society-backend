<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'account_id',
        'amount',
        'payment_date',
        'method',
        'status'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}