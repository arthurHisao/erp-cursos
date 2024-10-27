<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User; 
use App\Models\UserImage;
use App\Models\SocialiteUser;
use App\Models\Paginate\Paginate;
use App\Models\Auth\LoginAuth;
use App\Models\Image\StoreImage;
use Illuminate\Support\Facades\Auth;
use App\Models\Fields\ValidateFields;
use App\Models\Update\Update;

class PaymentStatus
{

    public function __construct() 
    {
        $this->paginate = new Paginate();
        $this->user = new User();
        $this->socialiteUser = new SocialiteUser();
        $this->loginAuth = new LoginAuth();
        $this->userImage = new UserImage();
        $this->storeImage = new StoreImage();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    
        return $next($request);
    }
}
