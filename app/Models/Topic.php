<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Topic extends Authenticatable
{
    //

    protected $table ='topics';

    protected $fillable = ['team_id','sub1','describtion1','status'];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
