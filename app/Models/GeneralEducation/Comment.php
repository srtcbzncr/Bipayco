<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\GeneralEducation\NewComment;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'ge_comments';
    protected $guarded = ['id'];
    protected $dispatchesEvents = [
      'created' => NewComment::class,
    ];

    public function course(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }
}
