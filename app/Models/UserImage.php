<?php

namespace App\Models;

use App\Models\User;
use App\Models\SocialiteUser;
use App\Models\AdminUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;

    
    //antigo
    protected $fillable = ['id_user', 'social_user_id','file_name'];
    
    //protected $fillable = ['file_name'];

    //formato antigo
    public function relUsers()
    {
        return $this->hasOne(User::class, 'id_user', 'id');
    }

    public function relUsersSocialite() {          //tabela imagem   //outra tabela socialite users     
        return $this->hasOne(SocialiteUser::class, 'social_user_id', 'id');
    }

    public function relAdminUsers() {      
        return $this->hasOne(UserAdmin::class, 'admin_id', 'id');
    }
}