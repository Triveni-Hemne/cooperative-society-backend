<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberContactDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'address',
        'city',
        'mobile_no',
        'phone_no',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}