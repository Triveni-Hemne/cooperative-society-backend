<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Agent extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'agent_code', 'commission_rate', 'status','name','email','phone','address','branch_id','joining_date','resignation_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

     protected static function booted()
    {
        static::creating(function ($agent) {
            $agent->created_by = auth()->id(); // Set the logged-in user as creator
        });

        static::updating(function ($agent) {
            $agent->updated_by = auth()->id(); // Set the logged-in user as updater
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}