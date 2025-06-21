<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'seasons',
        'description',
        'image_path',
    ];
    public function getSeasonsAttribute($value)
    {
        return explode(',', $value ?? '');
    }
    public function setSeasonsAttribute($value)
    {
        $this->attributes['seasons'] = implode(',', (array)$value);
    }
}