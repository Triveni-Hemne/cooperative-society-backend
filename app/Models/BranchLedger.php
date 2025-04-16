<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class BranchLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_code', 'gl_id', 'open_date', 'open_balance', 
        'balance', 'balance_type', 'item_type', 'created_by'
    ];

    public function generalLedger() {
        return $this->belongsTo(GeneralLedger::class, 'gl_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'created_by');
    }
}