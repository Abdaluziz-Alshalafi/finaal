<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Teacher extends Authenticatable
{
    //
    protected $table ='teachers';

    protected $fillable = ['id','name','email','id_university','role','status','password'];

    public function university()
    {
        return $this->belongsTo(University::class,'id','id_university');
    }

    public function college()
{
    return $this->belongsTo(Colls::class, 'id_college');
}
public function depart()
{
    return $this->belongsTo(Depart::class, 'id_depart');
}

    // public function supervisors()
    // {
    //     return $this->belongsTo( Project_supervisors::class);
    // }






}
