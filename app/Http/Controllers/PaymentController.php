<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Fields\ValidateFields;
use App\Models\Pay\Pay;
use Illuminate\Support\Facades\Session;
use App\Models\Paginate\Paginate;
use App\Models\Auth\LoginAuth;
use App\Models\User;
use App\Models\SocialiteUser;
use App\Models\Image\StoreImage;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private $user;
    private $socialiteUser;
    private $validate;
    private $pay;
    private $loginAuth;
    private $storeImage;

    public function __construct() 
    {
        $this->user = new User();
        $this->socialiteUser = new SocialiteUser();
        $this->validate = new ValidateFields();    
        $this->loginAuth = new LoginAuth();
        $this->storeImage = new StoreImage();
    }

    public function plans()
    {
        switch($this->loginAuth->validateUser()) {
            case $this->loginAuth->validateUser() === "userLogin":  
                return view('purchase.plan', [
                    'userId' => Auth::user()->id,
                    'userName' => $this->loginAuth->dottedText(),
                    'image' => $this->storeImage->insertImage(),
                ]);
            break;

            case $this->loginAuth->validateUser() === "socialLogin":
                return view('purchase.plan', [
                    'socialId' => $this->storeImage->getSocialId(),
                    'userName' => $this->loginAuth->dottedText(),
                    'image' => $this->storeImage->insertSocialImage()
                ]);
            break;
        }
    }

    /*gerando o boleto*/
    public function generateBankSlip(Request $request)
    {
        if($this->validate->validatePlan($request) === false) {
            return 'Verifique se digitou corretamente os campos';
        }
       
        //instanciando classe de pagamento
        $this->pay = new Pay($request);
        return $this->pay->bankSlip($request);

        /*if($this->pay->userExists() === true) {
            return $this->pay->bankSlip($request);
        } else {
            return 'Informe os seus dados';
        }*/
    }
}