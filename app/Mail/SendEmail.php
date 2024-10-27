<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;



class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $message;
    public $subject;
    private $token;
    private $createdAt;
    private $url;
    private $previousURL;
    private $segment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\stdClass $user, $token)
    {
        $this->token = $token;
        $this->user = $user;
        $this->createSession();
    }

    private function createSession() 
    {
        Session::put(['created_at' => time()]);
        $this->createdAt = Session::get('created_at');
        return $this->createdAt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //titulo do e-mail
        $this->subject = "ERP-CURSOS";
        //destinatario
        $this->to($this->user->email, $this->user->name);
       
        /*se for pelo link admin*/
        if(strpos(URL::previous(), 'admin') != false) {
            $this->previousURL = explode("/", URL::previous());
            $this->segment = $this->previousURL[4]; 
            $this->url = "http://localhost:8000/nova-senha/{$this->token}/{$this->segment}";

            return $this->view('template.templateEmail', [
                'url' => $this->url,
                'user' => $this->user
            ]);
        } 

        $this->url = "http://localhost:8000/nova-senha/{$this->token}";
        //menssagem do e-mail
        /*$this->message = "
            <p>Prezado(a) aluno(a) <b>{$this->user->name}</b></p>
            <a href='http://localhost:8000/nova-senha/{$this->token}'><p>Clique no aqui para redefinir a sua senha</p></a>
            <p>Atenciosamente,
            <p>ERP-CURSOS</p>";
        return $this->html($this->message)->subject($this->subject);*/
        
        return $this->view('template.templateEmail', [
            'url' => $this->url,
            'user' => $this->user
        ]);
    }
}

