<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Center extends Model
{
    use HasFactory;

    protected $fillable = ['subdivision_id', 'name', 'naav', 'address', 'description'];

    public function subdivision() {
        return $this->belongsTo(Subdivision::class);
    }
}