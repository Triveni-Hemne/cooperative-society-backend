<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class GeneralLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'name',
        'balance',
        'open_balance',
        'min_amount',
        'subsidiary',
        'group',
        'demand',
        'type',
        'gl_type',
        'item_of',
    ];

    public function schedule()
    {
        return $this->belongsTo(ScheduleLedger::class, 'schedule_id');
    }
}