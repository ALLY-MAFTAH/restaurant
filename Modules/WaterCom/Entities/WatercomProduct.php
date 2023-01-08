<?php

namespace Modules\Watercom\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WatercomProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'watercom_stock_id',
        'name',
        'type',
        'volume',
        'unit',
        'price',
        'measure',
        'status',

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function stock()
    {
        return  $this->belongsTo(WatercomStock::class);
    }
}
