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
        'stock_id',
        'quantity',
        'unit',
        'status',

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function stock()
    {
        return  $this->belongsTo(Stock::class);
    }
    public function item()
    {
        return  $this->belongsTo(Item::class);
    }
}
