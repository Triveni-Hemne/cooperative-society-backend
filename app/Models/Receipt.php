<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'receipt_no',
        'issued_by',
        'issue_date'
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}