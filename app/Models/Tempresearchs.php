<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Attachment;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tempresearchs extends Authenticatable
{
    //

    protected $fillable = ['id_student','student_names','research_name', 'research_description', 'approved'];


    public function researches()
    {
        return $this->hasMany(Research::class);
    }
}
