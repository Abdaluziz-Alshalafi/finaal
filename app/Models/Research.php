<?php

namespace App\Models;

 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Research extends Authenticatable
{
    // protected $table ='universities';

    protected $table ='researchs';

    protected $fillable = ['id_student','research_name', 'research_description', 'approved'];


    public function tempresearch()
        {
            return $this->belongsTo(Tempresearchs::class);
        }

    //
}
