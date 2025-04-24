<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Project_supervisors extends Authenticatable
{
    //
    protected $table ='project_supervisors';

    protected $fillable = ['id','id_teachers','team_id'];

    // public function teacher()
    // {
    //     return $this->belongsTo(related: Teacher::class);
    // }




    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'id_teachers');
    }
}
