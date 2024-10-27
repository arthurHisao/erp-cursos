<?php

namespace App\Models\Pay;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SocialiteUser;
use App\Models\Paginate\Paginate;

class Pay extends Model
{
    use HasFactory;
    
    private $token; 
    private $name;
    private $cpf;
    private $url;
    private $reference;
    private $value;
    private $user;
    private $socialite;
    private $formValue;

    public function __construct($request) {
        $this->formValue = json_decode($request->formValue);
        $this->token = env('JUNO_TOKEN');
        $this->name = $this->formValue->inputName;
        $this->cpf = $this->formValue->inputCPF;
        $this->reference = "1";
        $this->value = $this->plan($this->formValue->select);
        $this->user = new User();
        $this->socialite = new SocialiteUser();
    }

    /*retorna os precos dos planos*/
    public function plan($urlPlan) 
    {
        switch($urlPlan) {
            case 'Bronze':
            return '10.00';

            case 'Prata':
            return '20.00';

            case 'Ouro':
            return '50.00';
        }
    }

    public function userExists() {        
        /*
        *    metodo paginate contem os selects
        *    validando se existe o usuario com cpf informado
        */
        $paginate = new Paginate();
        if($paginate->checkUser($this->formValue) === true) {
            return true;
        }
        
        return false;
    }

    private function generate() {
        $this->url = "https://sandbox.boletobancario.com/boletofacil/integration/api/v1/issue-charge?";
        $this->url .= "token=" .$this->token."&";
        $this->url .= "description=Pagamento do curso&";
        $this->url .= "amount=" .$this->value."&";
        $this->url .= "payerName=".$this->name."&";
        $this->url .= "payerCpfCnpj=".$this->cpf."&";
        $this->url .= "responseType=XML";        
        return $this->url;
    }

    public function bankSlip($request) 
    {
        $xml = $this->generate(
            $this->token, 
            $this->reference, 
            $this->nome,
            $this->cpf,
            $this->valor
        );

        $boleto = simplexml_load_file($xml);
        $success = $boleto->success;

        if($success == true) {
            return $link = $boleto->data->charges->charge->link;
        } else {
            return "Ocorreu um erro tente novamente ou mais tarde";
        }
    }
}
