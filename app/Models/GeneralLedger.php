<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class GeneralLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_ledger_id', 'name', 'type', 'balance', 'open_balance',
        'min_amount', 'subsidiary', 'group', 'demand', 'type_detail',
        'gl_type', 'item_of'
    ];

    public function parentLedger() {
        return $this->belongsTo(GeneralLedger::class, 'parent_ledger_id');
    }
}