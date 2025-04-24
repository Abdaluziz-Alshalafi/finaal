<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Colls extends Authenticatable implements MustVerifyEmail
{
    //


    use HasFactory ,Notifiable;

    protected $table ='coll';

    protected $fillable = [
        'id',
        'coll_name',

        // إضافة حقل role
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_coll');
    }

}
