<?php

namespace Modules\Watercom\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Watercom extends Authenticatable
{
    use Notifiable, SoftDeletes, HasFactory;
    protected $guard = "watercom";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'role_id',
        'email',
        'password',
    ];
    protected $dates = [
        'deleted_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sales()
    {
        return  $this->hasMany(WatercomSale::class);
    }
    public function role()
    {
        return  $this->belongsTo(WatercomRole::class);
    }
}
