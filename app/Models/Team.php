<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request as ModelsRequest;


class Team extends Model
{

    protected $table ='teams';

    protected $fillable = ['id','id_student','team_sub1','describtion1'];

    public function topics()
    {
        return $this->hasMany(Topic::class, 'team_id', 'id');
    }
    public function topic()
    {
        return $this->hasOne(Topic::class);

    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'id_student');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'id');
    }
    public function students_req()
    {
        return $this->hasMany(ModelsRequest::class, 'team_id');
    }


    // public function team()
    // {
    //     return $this->belongsTo(Team::class, 'team_id');
    // }



public function projectSupervisors()
    {
        return $this->hasMany(Project_supervisors::class, 'team_id', 'id');
    }


    // علاقة الفريق مع الطلاب (من خلال الـ requests)
public function requests()
{
    return $this->hasMany(Request::class, 'team_id', 'id');
}

// علاقة الفريق مع المشرفين (من خلال الـ project_supervisors)
// public function supervisors()
// {
//     return $this->hasMany(Project_supervisors::class, 'team_id', 'id');
// }

// علاقة الفريق مع المواضيع (البحوث)
// public function topics()
// {
//     return $this->hasMany(Topic::class, 'team_id', 'id');
// }




//         public function students()
// {
//     return $this->hasMany(Student::class, 'team_id', 'id');
// }

    // حذف البيانات المرتبطة عند حذف فريق
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($team) {
            $team->topics()->delete();
            $team->projectSupervisors()->delete();
            $team->requests()->delete();
        });
    }



}