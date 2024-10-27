<?php

namespace App\Http\Controllers;

use App\Models\Auth\RegisterUser;
use App\Models\User;
use App\Models\Plans;
use Illuminate\Http\Request;
use App\Models\Fields\ValidateFields;
use \stdClass;
use Illuminate\Support\Facades\Storage;
use App\Models\UserImage;
use Illuminate\Support\Facades\Session;
use App\Models\Paginate\Paginate;
use Illuminate\Support\Facades\Auth;
use App\Models\Image\StoreImage;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerForm(Request $request)
    {
        $Instructor = $request->segment(2);
        return view('auth.register', [
            "Instructor" => $Instructor
        ]);
    }

    public function loginForm(Request $request) 
    {
        $Instructor = $request->segment(2);
        return view('auth.login', [
            "Instructor" => $Instructor
        ]);
    }

    public function aboutUs()
    {
        return view('about.aboutUs');
    }

    public function courses(Paginate $paginate)
    {
        return view('courses.courses', [
            'videos' => $paginate->getCourses()
        ]);
    }

    public function details(Paginate $paginate, Request $request)
    {
        return view('courses.details', [
            'details' => $paginate->getCoursesDetails($request)
        ]);
    }

    public function inputSearch(Paginate $paginate, Request $request) 
    {
        /*validando o campo de pesquisa*/
        $validateFields = new ValidateFields();    
        $validateFields->validateInputSearch($request);

        if($paginate->courses($request) === false) {
            
            return view('courses.courses', [
                'error' => 'Não foi encontrado resultado para '.$request->search
            ]);
        }

        $search = $request->search;
        return view('courses.courses', [
            'courses' => $paginate->courses($request),
            'search' => $search
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
}