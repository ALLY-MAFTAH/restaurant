<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'unit',
        'cost',
        'status',

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function items()
    {
        return  $this->belongsToMany(Item::class);
    }
}
