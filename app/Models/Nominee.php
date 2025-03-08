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
        'name',
        'naav',
        'age',
        'gender',
        'relation',
        'nominee_image',
        'address',
        'marathi_address',
        'adhar_no'
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
}