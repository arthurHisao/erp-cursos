<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAdmin;
use App\Models\UserResets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use \stdClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class ForgotPasswordController extends Controller
{
    private $user;
    private $select;
    private $insert;
    private $update;
    private $token;
    private $tokenLink;
    private $email;
    private $password;
    private $confirm;
    private $previousURL;

    public  function __construct() {
        $this->previousURL = URL::previous();
    }

    /*formulario de validar e-mail*/
    public function emailForm()
    {
        if(strpos($this->previousURL, 'admin') != false) {
            return view('auth.passwords.email');
        } 
        return view('auth.passwords.email');
    }

    /*formulario de resetar a senha*/
    public function resetForm(Request $request)
    {
        $timeDiff = (time() - Session::get('created_at')) / 60;

        //token do link
        $this->tokenLink = $request->segment(2);
        
        //obtendo o token atraves do link
        $this->select = UserResets::where('token', $this->tokenLink)->first(); 

        /*validando o tempo da sessao*/
        if($timeDiff >= 60 || !$this->select) {
            $this->update = UserResets::where('token', $this->tokenLink)->update(['token' => "null"]);
            Session::forget('created_at');
            return redirect()->route('user.reset');
        }
        return view('auth.passwords.reset');
    }

    /*dispara o e-mail*/
    public function validateEmail(Request $request)
    { 
        $this->token = bin2hex(random_bytes(20));

        $this->select = User::select("name", "email")->where(["email" => $request->email])->first();

        if(!$this->select) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Email informado não existe!']);
        }

        $name = $this->select->name;
        $email = $this->select->email;

        //inserindo os dados
        $this->InsertData($request);

        /*criando um objeto*/
        $this->user = new stdClass();
        $this->user->name = $name;
        $this->user->email = $email;
    
        /*enviando e-mail*/
        $sendEmail = new SendEmail($this->user, $this->token);
        
        Mail::send($sendEmail); 
        
        /*menssagem*/
        Session::flash('status', 'Email enviado com sucesso!');
        return back();
    }

    /*insere os dados do usuario que alterou a senha*/
    private function InsertData($request) {
        //verificando se existe registro
        $this->select = UserResets::select('token')->where('email', $request->email)->first();

        if(!$this->select) {
            $this->insert = UserResets::insert([
                'email' => $request->email,
                'token' => $this->token,
                'created_at' => Carbon::now() //data e hora atual
            ]);
        } 
        return $this->update = UserResets::where('email', $request->email)->update(['token' => $this->token]);
    }

    /*reseta a senha*/
    public function resetPassword(Request $request) 
    {
        $this->email = $request->email;
        $this->password = $request->password;
        $this->confirm = $request->confirm;

        /*validacoes*/
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->withErrors(["E-mail inválido!"]);
        }

        if(empty($this->email) || empty($this->password) || empty($this->confirm)) {
            return redirect()->back()->withInput()->withErrors(["Os campos não podem ser vazios!"]);
        } else if($this->password != $this->confirm){
            return redirect()->back()->withInput()->withErrors(["As senhas não conhecidem!"]);
        }

        /*obtendo o token do link anterior*/
        $segment = explode('/', URL::previous());
        $this->tokenLink = $segment[4];

        /*update na tabela usuario*/
        if(strpos($this->previousURL, 'admin') != false) {
            $this->update = UserAdmin::where('email', $request->email)->update(['password' => hash::make($request->password)]);        
        } else {
            $this->update = User::where('email', $request->email)->update(['password' => hash::make($request->password)]);
        }

        /*invalidando o acesso a pagina*/
        if($this->update) {
            $this->update = UserResets::where('token', $this->tokenLink)->update(['token' => "null"]);
        }
        
        Session::forget('createdAt');
        return redirect()->route('user.login');
    }
}
