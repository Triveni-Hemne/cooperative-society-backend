<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalDemandPostingEntry extends Model
{
    use HasFactory;

    protected $table = 'personal_demand_posting_entries';

    protected $fillable = [
        'posting_id',
        'gl_code',
        'gl_name',
        'account_code',
        'amount',
        'balance',
    ];

    // Relationship
    public function posting()
    {
        return $this->belongsTo(PersonalDemandPosting::class, 'posting_id');
    }
}