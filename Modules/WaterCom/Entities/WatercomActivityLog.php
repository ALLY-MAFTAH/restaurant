<?php

namespace Modules\Watercom\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatercomActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'module',
        'url',
        'method',
        'ip',
        'agent',
        'user_id'

    ];
}
