<?php

namespace Modules\Watercom\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WatercomSale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'item_id',
        'stock_id',
        'user_id',
        'user_name',
        'name',
        'volume',
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
        return  $this->belongsTo(WatercomUser::class);
    }
    public function watercom()
    {
        return  $this->belongsTo(Watercom::class);
    }

    public function stock()
    {
        return  $this->belongsTo(WatercomStock::class);
    }
}
