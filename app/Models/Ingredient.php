<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'item_id',
        'material_id',
        'quantity',
        'price',
        'unit',
        'status',

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function material()
    {
        return  $this->belongsTo(Material::class);
    }
    public function item()
    {
        return  $this->belongsTo(Item::class);
    }
}
