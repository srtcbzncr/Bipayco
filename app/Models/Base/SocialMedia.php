<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialMedia extends Model
{
    use SoftDeletes;

    protected $table = 'bs_social_medias';
    protected $guarded = ['id'];

    public function instructors(){
        return $this->belongsToMany('App\Models\Auth\Instructor', 'bs_instructors_social_medias_table', 'social_media_id', 'instructor_id')->withPivot('url');
    }
}
