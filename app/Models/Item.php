<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'cost',
        'status',
        'unit',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function ingredients()
    {
        return  $this->hasMany(Ingredient::class);
    }
    public function products()
    {
        return  $this->hasMany(Product::class);
    }
    public function sales()
    {
        return  $this->hasMany(Sale::class);
    }
}
