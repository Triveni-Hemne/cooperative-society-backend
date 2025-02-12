<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'director_id',
        'share_amount',
        'welfare_fund',
        'page_no',
        'current_balance',
        'monthly_balance',
        'dividend_amount',
        'monthly_deposit',
        'demand',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }
}