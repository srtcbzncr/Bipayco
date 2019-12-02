<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;

    protected $table = 'auth_instructors';
    protected $guarded = ['reference_code'];

    public function User(){
        return $this->morphOne('App\Models\Auth\User', 'profile');
    }

    public function SocialMedias(){
        return $this->belongsToMany('App\Models\Base\SocialMedia', 'bs_instructors_social_medias', 'instructor_id', 'social_media_id')->withPivot('url');
    }

    public function School(){
        return $this->belongsTo('App\Models\Base\School', 'school_id');
    }

    public function District(){
        return $this->belongsTo('App\Models\Base\District', 'district_id');
    }
}
