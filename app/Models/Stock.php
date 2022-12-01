<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function Ingredient()
    {
        return $this->hasOne(Ingredient::class);
    }

    public function getCapacity(){
       return $this->capacity - $this->used_capacity;
    }
}
