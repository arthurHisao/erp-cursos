<?php

namespace App\Http\Controllers;

use App\Models\Auth\RegisterUser;
use App\Models\Auth\LoginAuth;
use App\Models\SocialiteUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Fields\ValidateFields;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    private $providerName;
    private $validateFields;
    private $loginAuth;
    private $previousURL;

    public function __construct() 
    {
        $this->register = new RegisterUser();
        $this->validateFields = new ValidateFields();
        $this->loginAuth = new LoginAuth();
    }

    /*redireciona para a pagina do estudante*/
    public function studentPage()
    {
        if($this->loginAuth->validateURL() === "userLogin") {
            return view('students.students');
        } else if ($this->loginAuth->validateURL() === "socialLogin") {
            return view('students.students');
        }
        return redirect()->route('user.login');
    }

    public function store(Request $request)
    {    
        $this->previousURL = url()->previous();
        
        //validando se e instrutor
        if(strpos($this->previousURL, 'admin') != false) {
            //$this->validateFields->validateRegisterForm($request);    
            
            $this->register = new RegisterUser();
            
            if($this->register->saveAdmin($request) === true){
                return redirect()->route('instructor.login');
            }                
        } else {
            //validacao
            if($this->validateFields->validateRegisterForm($request) === false):
                return redirect()->back()->withInput()->withErrors(['Verifique se preencheu os campos corretamente']); 
            endif;
            
            $this->register = new RegisterUser();
            if($this->register->saveUser($request) === true):
                return redirect()->route('user.login');
            endif;      
        }
        return redirect()->back()->withInput()->withErrors(['Você já possui uma conta cadastrada!']); 
    }

    public function loginDo(Request $request)
    {
        $this->previousURL = url()->previous();

        if(strpos($this->previousURL, 'admin') != false) {
            /*validacao*/
            $this->validateFields->validateLoginForm($request);
                    
            /*login*/
            if($this->loginAuth->login($request) === true) {
                return redirect()->route('admin.list.users');
            }               
        } else {
            /*validacao*/
            $this->validateFields->validateLoginForm($request);
                        
            /*login*/
            if($this->loginAuth->login($request) === true) {
                return redirect()->route('user.student');
            }   
        }
        return redirect()->back()->withInput()->withErrors(['error' => 'Usuário ou a senha estão incorretos']);
    }

    public function redirectToGoogle() 
    {
        return Socialite::driver('google')->redirect();
    }

    /*obtem as informacoes do usuario do google */
    public function handleGoogleCallback(Request $request) 
    {
        $authUser = Socialite::driver('google')->user();
            
        if($this->loginAuth->loginWithProvider($request, $authUser) === true) {
            return redirect()->route('user.student')->with(['socialUser' => Session::get('name')]);    
        }
        return redirect()->back()->withInput()->withErrors(['Você já possui uma conta cadastrada!']); 
    }

    /*redireciona o usuario para a pagina de login do facebook */
    public function redirectToFace() 
    {
        return Socialite::driver('facebook')->redirect();
    }

    /*obtem as informacoes do facebook do usuario */
    public function handleFaceCallback(Request $request) 
    {        
        $authUser = Socialite::driver('facebook')->user();

        if($this->loginAuth->loginWithProvider($request, $authUser) === true) {
            return redirect()->route('user.student')->with(['socialUser' => Session::get('name')]);    
        } 
        return redirect()->back()->withInput()->withErrors(['Você já possui uma conta cadastrada!']); 
    }

    public function logout(Request $request) 
    {
        $this->loginAuth->logoutSession($request);
        return redirect()->route('user.index');
    }
}