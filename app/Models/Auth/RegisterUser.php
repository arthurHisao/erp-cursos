<?php

namespace App\Models\Auth;

use App\Models\User;
use App\Models\UserAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class RegisterUser extends Model
{
    use HasFactory;

    private $select;

    public function saveUser($request)
    {
        //verificando a existencia do usuario
        $this->select = User::where(['email' => $request->email])
            ->where(['name' => $request->name])
            ->first();

        if(!$this->select) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->cpf = str_replace(['.','-'], '', trim($request->cpf));
            $user->birthday = str_replace('/', '', trim($request->birthday));
            $user->phone = str_replace(['(',')','-'], '', trim($request->phone));
            $user->state = $request->state; 
            $user->payment_status = "NULL";
            $user->save(); //salva no banco de dados
            return true;
        }
        return false;
    }

    public function saveAdmin($request)
    {
        //verificando a existencia do usuario
        //SELECT id FROM user_admins WHERE email = "blab@gmail.com" LIMIT 1;
        $this->select = UserAdmin::select('id')->where(['email' => $request->email])->first();
       
        if(!$this->select) {
            $this->select = UserAdmin::where(['id' => 1])->first();
            if($this->select) {
                $userAdmin = new UserAdmin();
                $userAdmin->name = $request->name;
                $userAdmin->email = $request->email;
                $userAdmin->password = Hash::make($request->password);
                $userAdmin->permission = "Instrutor";
                $userAdmin->save(); //salva no banco de dados
                return true;    
            }
            $userAdmin = new UserAdmin();
            $userAdmin->name = $request->name;
            $userAdmin->email = $request->email;
            $userAdmin->password = Hash::make($request->password);
            $userAdmin->permission = "Administrador";
            $userAdmin->save(); //salva no banco de dados
            return true; 
        } 
        return false;
    }
}
