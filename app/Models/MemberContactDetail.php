<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class MemberContactDetail extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'member_id', 'address', 'marathi_address', 'city', 'mobile_no', 'phone_no'
    ];

    public function member() {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function routeNotificationForWhatsApp()
    {
        if ($this->mobile_no) {
            return '+91' . ltrim($this->mobile_no, '0'); // Convert to international format
        }

        return null;
    }
}