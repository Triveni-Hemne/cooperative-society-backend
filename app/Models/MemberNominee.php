<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberNominee extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'name',
        'age',
        'gender',
        'relation',
        'image',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}