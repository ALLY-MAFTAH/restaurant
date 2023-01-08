<?php

namespace Modules\Watercom\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WatercomStock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'volume',
        'quantity',
        'type',
        'measure',
        'unit',
        'cost',
        'status',

    ];

    protected $dates = [
        'deleted_at'
    ];


    public function product()
    {
        return  $this->hasOne(WatercomProduct::class);
    }
    public function sales()
    {
        return  $this->hasMany(WatercomSale::class);
    }
}
