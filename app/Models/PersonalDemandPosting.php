<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalDemandPosting extends Model
{
    use HasFactory;

    protected $table = 'personal_demand_postings';

    protected $fillable = [
        'department_id',
        'member_id',
        'month',
        'from_date',
        'to_date',
        'posting_date',
        'year',
        'created_by',
        'branch_id',
        'is_transferred',
        'posting_type',
        'total_amount',
        'ledger_id',
        'account_id',
        'acc_type',
        'cheque_no',
        'narration',
    ];

    protected $casts = [
        'is_transferred' => 'boolean',
        'from_date' => 'date',
        'to_date' => 'date',
        'posting_date' => 'date',
    ];

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function ledger()
    {
        return $this->belongsTo(GeneralLedger::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }


    public function entries()
    {
        return $this->hasMany(PersonalDemandPostingEntry::class, 'posting_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    // app/Models/PersonalDemandPosting.php

}