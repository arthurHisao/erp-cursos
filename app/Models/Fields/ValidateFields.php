<?php

namespace App\Models\Fields;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ValidateFields
{
    use HasFactory;

    private $inputName;
    private $inputEmail;

    public function validateInputSearch($request) 
    {
        $inputSearch = strval(strip_tags($request->search));
        return $request->validate(['search' => 'required']);
    }

    public function validateLoginForm($request) {
        $email = strval(strip_tags($request->email));
        $password = strval(strip_tags($request->password));
        
        return $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    }

    /*validando a pagina de planos*/
    public function validatePlan($request) 
    {
        $formValue = json_decode($request->formValue);       
        foreach($formValue as $form) {
            //validando a entrada
            $toString = strval(strip_tags($form));
            $preventDuplicate = preg_match_all('/(.)\1+\1+/', $form, $matches);

            if($preventDuplicate || empty($form)) {
                return false;
            }
        }
        
        //validando campos individualmente
        $validateName = preg_match_all('/[^a-zA-Z À-ú]/', $formValue->inputName, $matches);
        $validateCPF = preg_match_all('/[^0-9]/', $formValue->inputCPF, $matches);
        $categories = preg_match_all('/[^Bronze|Prata|Ouro]/', $request->plans, $matches);

        if($validateName || $validateCPF && strlen($validateCPF > 11 || $categories) ) {
            return false;
        }
    }

    public function validateRegisterForm($request) 
    {
        $fields = array(
            $request->name,
            $request->email,
            $request->cpf,
            $request->phone
        );

        /*previne caracteres repetidos*/
        foreach($fields as $value) {
            $preventDuplicate = preg_match_all('/(.)\1+\1+/', $value, $matches);
          
            if($preventDuplicate):
                return false;
            endif;
        }

        /*aplicando regex para o campo nome*/
        $regexName = preg_match_all('/[^a-zA-Z]/', $request->name, $matches);
        $inputBirthday = explode("/", $request->birthday);
        $inputDate = $inputBirthday[0];
        $inputMonth = $inputBirthday[1];
        $inputYear = $inputBirthday[2];
        $actualYear = date("Y");
    
        /*validando options*/
        $categories = preg_match_all('/[^AC|AP|AM|BA|CE|DF|ES|GO|MA|MT|MS|MG|PA|PB|PR|PE|PI|RJ|RN|RS|RO|RR|SC|SP|SE|TO]/', $request->state, $matches);

        /*validando se a data e valida e se e menor que 1930*/
        if(checkdate($inputMonth,$inputDate,$inputYear) === false):
            return false;
        endif;

        if($regexName || $actualYear - $inputYear < 18 || $inputYear > $actualYear || $inputYear <= 1930 || $categories):   
            return false;
        endif;         

        return $validate = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'cpf' => 'required|max:14',
            'birthday' => 'required|max:10',
            'phone' => 'required|min:15',
            'state' => 'required'
        ]);        
    }

    /*validando os campos do modal da pagina do estudante*/
    public function validateStudentProfile($request)
    {
        $form = json_decode($request->formValue);
        $preventDuplicate = preg_match_all('/(.)\1+\1+/', $form->inputName, $matches);
        $validateName = preg_match_all('/[^a-zA-Z]/', $form->inputName, $matches);
        $validateEmail = filter_Var($form->inputEmail, FILTER_VALIDATE_EMAIL);

        if($validateName || $preventDuplicate || $validateEmail === false) {
            return false;
        }
    }

    /*validando os campos do modal da pagina do administrador*/
    public function validateAdminProfile($request)
    {
        $form = json_decode($request->formValue);
        $preventDuplicate = preg_match_all('/(.)\1+\1+/', $form->inputName, $matches);
        $validateName = preg_match_all('/[^a-zA-Z]/', $form->inputName, $matches);
        $validateEmail = filter_Var($form->inputEmail, FILTER_VALIDATE_EMAIL);

        if($validateName || $preventDuplicate || $validateEmail === false) {
            return false;
        }
    }

    /*validando pagina administrador descricao do video*/
    public function validateVideoDescription($request)
    {
        /*request do ajax*/
        $decodeVal = json_decode(strip_tags($request->values));

        /*validando link*/
        $validateLink = preg_match_all('/^\/|[^a-z0-9-]|^-|(-)\1|-$/', $decodeVal->link, $matches);

        /*validando options*/
        $categories = preg_match_all('/[^ERP|Desenvolvimento de Softwares|Design|Outros]/', $decodeVal->categories, $matches);
        
        /*validando link*/
        if($validateLink || $categories):
            return false;
        endif;

        foreach($decodeVal as $field) {
            /*previnindo caracteres 3 repetidos*/
            $preventDuplicate = preg_match_all('/(.)\1+\1+/', $field, $matches);

            /*regex do campo descricao*/
            $Description = preg_match_all('/[^A-Za-z À-ú0-9\/\-\._\(\):]/', $field, $matches);


            if($preventDuplicate || $Description || empty($field)) {
                return false;
            }
        }
    }
}