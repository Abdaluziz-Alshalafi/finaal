<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Request as ModelsRequest;

class Student extends Authenticatable
{



    protected $fillable = ['id','name','Academic_number', 'phone','email','id_university','college','depart'];

    public function university()
    {
        return $this->belongsTo(University::class,'id','id_university');
    }
    // public function team()
    // {
    //     return $this->belongsTo(Team::class,'id_student');
    // }

    public function requests()
    {
        return $this->belongsTo(ModelsRequest::class,'student_id');
    }

//     public function team()
// {
//     return $this->hasMany(Team::class,  'id','id_student');
// }

        // return $this->belongsTo(University::class, 'uni_id');
        public function team()
        {
            return $this->hasOne(Team::class, 'id_student');
        }


        public function profile()
    {
        return $this->morphTo();
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }
    }



