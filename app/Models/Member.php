<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Member extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'category_id', 'name','naav', 'dob', 'gender', 'age',
        'date_of_joining', 'religion', 'caste', 'm_reg_no', 'employee_id',
        'pan_no', 'adhar_no','branch_id', 'created_by','member_branch_id', 
        'images', 'designation_id', 'cpf_no', 'status', 'division_id', 'subdivision_id', 'membership_date'
    ];


    public function contact()
    {
        return $this->hasOne(MemberContactDetail::class, 'member_id');
    }
    public function nominee()
    {
        return $this->hasOne(Nominee::class, 'member_id');
    }
    public function bankdtl()
    {
        return $this->hasOne(MemberBankDetail::class, 'member_id');
    }
    public function financialdtl()
    {
        return $this->hasOne(MemberFinancial::class, 'member_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function memberBranch()
    {
        return $this->belongsTo(Branch::class, 'member_branch_id');
    }
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
    public function subdivision()
    {
        return $this->belongsTo(Subdivision::class, 'subdivision_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function routeNotificationForWhatsApp()
    {
        // Delegate to contact detail
        return optional($this->contact)->routeNotificationForWhatsApp();
    }

}