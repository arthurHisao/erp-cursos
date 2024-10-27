<?php

namespace App\Models;

use App\Models\UserImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class SocialiteUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','provider_name','name','email'];    
}

