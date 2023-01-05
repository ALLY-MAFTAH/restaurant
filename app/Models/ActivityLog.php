<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
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
