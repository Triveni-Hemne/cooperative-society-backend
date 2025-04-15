<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id','employee_id','department_id', 'subcaste_id', 'name','naav', 'dob', 'gender', 'age',
        'date_of_joining', 'religion', 'category', 'caste', 'm_reg_no',
        'pan_no', 'adhar_no','branch_id'
    ];

    public function subcaste() {
        return $this->belongsTo(Subcaste::class, 'subcaste_id');
    }
    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
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
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    // app/User.php

    public function routeNotificationForWhatsApp()
    {
    return $this->phone_number;
    }
}