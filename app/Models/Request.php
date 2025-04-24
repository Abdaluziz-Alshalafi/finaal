<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Request extends Authenticatable

{


    protected $fillable = ['id','student_id','team_id','approved','status'];


    public function tempresearch()
        {
            return $this->belongsTo(Tempresearchs::class);
        }


    //     protected static function booted()
    // {
    //     // الاستماع لحدث التحديث (updating)
    //     static::updating(function ($requestsss) {
    //         // تحديث حقل آخر تعديل
    //         $requestsss->last_updated_at = now(); // استخدم الحقل المناسب لديك
    //     });
    // }

        // public function student()
        // {
        //     return $this->belongsTo(Student::class, 'student_id');
        // }
        public function students()
{
    return $this->hasMany(Student::class, 'id', 'student_id');
}

public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
        // جلب بيانات البحث (Topic) بناءً على `team_id`
        // public function  topic()
        // {
        //     return $this->hasOne(Topic::class, 'team_id', 'team_id');
        // }


            public function topics()
            {
                return $this->hasMany(Topic::class,'team_id', 'team_id');
            }

            // public function student()
            // {
            //     return $this->hasMany(Topic::class,'team_id', 'team_id');
            // }



        // جلب المشرفين المرتبطين بـ `team_id`
        public function supervisors()
        {
            return $this->hasMany(Project_supervisors::class, 'team_id', 'team_id');
        }




    // علاقة مع جدول الفرق



    // public function teamStudent()
    // {
    //     return $this->hasOne(Team::class, 'team_id', 'id');
    // }
    public function tea()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }




    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class);
    // }

}




