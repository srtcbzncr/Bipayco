<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;

    protected $table = 'auth_instructors';
    protected $guarded = ['reference_code'];

    public function socialMedias(){
        return $this->belongsToMany('App\Models\Base\SocialMedia', 'bs_instructors_social_medias', 'instructor_id', 'social_media_id')->withPivot('url');
    }

    public function school(){
        return $this->belongsTo('App\Models\Base\School');
    }

    public function user(){
        return $this->hasOne('App\Models\Auth\User');
    }
}
