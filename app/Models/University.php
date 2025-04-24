<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    // protected $table ='university';
    protected $table ='universities';

    protected $fillable = ['id','name','number','phone','address','status'];
    protected $primaryKey ='id';


    public function students()
    {
        return $this->hasMany(Student::class, 'id_university', 'id');
    }

    public function teacher()
    {
        return $this->hasMany(Teacher::class, 'id_university', 'id');
    }
}

