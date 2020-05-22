<?php

namespace App\Models\UsersOperations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'is_choice', // accept-reject var mı?
        'content', // bildirim içeriği
        'accept_url', // is_choice bir ise kabul butonuna basıldığında gidilecek url
        'reject_url', // is_choice bir ise reddet butonuna basıldığında gidilecek url
        'redirect_url', // is_choice sıfır ise yönlenecek url
        'isSeen' // bildirim görüldümü
    ];

    protected $table = "notification";
    public $timestamps = true;


}
