<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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