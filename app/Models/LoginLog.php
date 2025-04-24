<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'role',
        'ip_address',
        'user_agent',
        'logged_in_at',
    ];
}

