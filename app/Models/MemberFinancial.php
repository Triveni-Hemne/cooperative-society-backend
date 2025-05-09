<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MemberFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'director_id', 'share_amount', 'welfare_fund', 'page_no',
        'current_balance', 'monthly_balance', 'dividend_amount', 'monthly_deposit',
        'demand', 'type','number_of_shares'
    ];

    public function member() {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function director() {
        return $this->belongsTo(Member::class, 'director_id');
    }
}