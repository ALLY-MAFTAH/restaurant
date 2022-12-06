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
        'user_id',
        'status',

    ];

    protected $dates = [
        'deleted_at'
    ];
    public function product()
    {
        return  $this->belongsTo(Product::class);
    }
    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
