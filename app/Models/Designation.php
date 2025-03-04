<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'naav', 'description', 'division_id', 'subdivision_id', 'center_id'];

     public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function subdivision() {
        return $this->belongsTo(Subdivision::class);
    }
     public function center() {
        return $this->belongsTo(Center::class);
    }
}