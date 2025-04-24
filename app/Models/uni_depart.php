<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class uni_depart extends Model
{
    protected $table ='uni_depart';

    protected $fillable = ['id','id_uni','id_depart','status'];


}
