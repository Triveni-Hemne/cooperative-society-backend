<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Center extends Model
{
    use HasFactory;

    protected $fillable = ['division_id', 'subdivision_id', 'name', 'naav', 'address', 'description', 'marathi_description', 'marathi_address'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function subdivision() {
        return $this->belongsTo(Subdivision::class);
    }
}