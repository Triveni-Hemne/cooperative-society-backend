<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DayBegin extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'branch_id',
        'user_id',
        'opening_cash_balance',
        'status',
        'remarks',
        'created_by'
    ];

    // creator
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    } 
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    // day beginner
     public function users()
    {
        return $this->belongsTo(Member::class, 'user_id');
    } 
}