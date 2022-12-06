<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'item_id',
        'quantity',
        'container',
        'price',
        'unit',
        'status',

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function item()
    {
        return  $this->belongsTo(Item::class);
    }
    public function sales()
    {
        return  $this->hasMany(Sale::class);
    }
}
