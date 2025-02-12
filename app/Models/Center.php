<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $fillable = [
        'subdivision_id',
        'name',
        'address',
        'description',
    ];

    public function subdivision()
    {
        return $this->belongsTo(Subdivision::class);
    }
}