<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
     use HasFactory;

    protected $fillable = [
        'member_id',
        'name',
        'email',
        'contact_no',
        'designation_id',
        'status',
        'from_date',
        'to_date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}