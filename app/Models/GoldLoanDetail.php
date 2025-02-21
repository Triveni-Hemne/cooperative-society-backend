<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoldLoanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id', 'gold_weight', 'gold_purity', 'market_value', 'pledged_date', 'release_status', 'release_date'
    ];

    public function loan() {
        return $this->belongsTo(Loan::class);
    }
}