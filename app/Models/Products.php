<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class products extends Model
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    use HasFactory;
    
    protected $fillable = [
    'product_name',
    'price',
    'stock',
    'company_id',
    'comment',
    'img_path',
];
}

