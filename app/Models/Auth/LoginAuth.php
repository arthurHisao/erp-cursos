<?php

namespace App\Models\Auth;

use App\Models\User;
use App\Models\SocialiteUser;
use App\Models\UserAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;



class LoginAuth extends Model
{
    use HasFactory;

    private $select;
    private $providerName;

    public function dottedText()
    {
        //$userName = Auth::user()->name;
        if(Auth::check()) {
            $userName = Auth::user()->name;
            return strlen($userName) > 8 ? substr($userName, 0, 8) .'...' : $userName;
        } else {
            $userName = Session::get('name');
            return strlen($userName) > 8 ? substr($userName, 0, 8) .'...' : $userName;
        }
    }

    public function validateUser()
    {
        if(Session::has('id')) {
            $socialId = Session::get('id');
            $userLogin = SocialiteUser::select('id')->where(['social_user_id' => $socialId])->first();
            return "socialLogin";    
        }        
        else if(Auth::check()) {
            return "userLogin";
        }
    }

    public function login($request) 
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(strpos(url()->previous(), 'admin') != false) {
            Auth::guard('userAdmin')->attempt($credentials);  
            $request->session()->regenerate();
            return true;      
        } else {
            Auth::attempt($credentials);
            $request->session()->regenerate();
            return true;
        }
    }

    public function loginWithProvider($request, $authUser) {
        //obtendo o nome da provedora
        $providerName = $request->segment(2);
      
        //metodo para registrar 
        $this->registerOnLogin($authUser, $providerName);   
        
        //verificando se existe uma sessao
        if(Session::has("id")) {
            return true;
        } 
        return false;
    }

    private function registerOnLogin($authUser, $providerName)
    {
        //select do usuario
        $userId = SocialiteUser::where(['social_user_id' => $authUser->id])->first();        

        //inserindo valor no banco 
        if(!$userId) {
            //caso haja duplicidade de e-mails
            if($this->select = SocialiteUser::where(['email' => $authUser->email])->first()) {
                return false;
            }
            //cadastrando usuario
            $socialUser = new SocialiteUser();
            $socialUser->social_user_id = $authUser->id;
            $socialUser->provider_name = $providerName;
            $socialUser->name = $authUser->name;
            $socialUser->email = $authUser->email;
            $socialUser->payment_status = "NULL";
            $socialUser->save(); //salva no banco de dados
            $this->createSession($authUser->id, $authUser->name);
            return true;
        } 

        $this->createSession($authUser->id, $authUser->name);
        return true;
    } 

    private function createSession($userId, $userName) {
        //cria uma sessao
        Session::put([
            'id' => $userId,
            'name' => $userName, 
            'created_at' => time()
        ]);
    }

    public function logoutSession($request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}