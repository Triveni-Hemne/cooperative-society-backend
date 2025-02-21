<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nominee extends Model
{
   use HasFactory;

   protected $fillable = [
        'member_id', 'linked_entity_id', 'linked_entity_type',
        'name', 'age', 'gender', 'relation', 'nominee_image'
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function linkedEntity() {
        return $this->morphTo();
    }
}