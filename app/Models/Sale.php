<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'item_id',
        'user_id',
        'user_name',
        'name',
        'container',
        'quantity',
        'unit',
        'price',
        'date',
        'status',

    ];

    protected $dates = [
        'deleted_at'
    ];
    
    public function user()
    {
        return  $this->belongsTo(User::class);
    }
    public function item()
    {
        return  $this->belongsTo(Item::class);
    }
}
