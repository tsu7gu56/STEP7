<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Company extends Model
{
    public function products()
    {
        return $this->hasMany(Products::class);
    }
    use HasFactory;
}
