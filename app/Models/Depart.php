<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Colls;
class Depart extends Authenticatable implements MustVerifyEmail
{
    //


    use HasFactory ,Notifiable;

    protected $table ='depart';

    protected $fillable = [
        'id',
        'depart_name',

        // إضافة حقل role
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_coll');
    }

    public function college()
{
    return $this->belongsTo(Colls::class, 'id_coll');
}
}
