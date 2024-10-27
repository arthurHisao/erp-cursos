<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\UserImage;
use App\Models\SocialiteUser;
use App\Models\Fields\ValidateFields;
use App\Models\Update\Update;
use App\Models\Paginate\Paginate;
use App\Models\Auth\LoginAuth;
use App\Models\Image\StoreImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
Use Carbon\Carbon;
use App\Models\Delete\Delete;

class StudentController extends Controller
{
    private $providerName;
    private $validateFields;
    private $loginAuth;

    public function __construct() 
    {
        $this->paginate = new Paginate();
        $this->user = new User();
        $this->socialiteUser = new SocialiteUser();
        $this->loginAuth = new LoginAuth();
        $this->userImage = new UserImage();
        $this->storeImage = new StoreImage();
    }

    //area do aluno
    public function studentPage()
    {   
        /*carrega os cursos da pagina do aluno*/
        switch($this->loginAuth->validateUser()) {
            case $this->loginAuth->validateUser() === "userLogin":
                /*insere uma imagem de perfil*/
                $this->storeImage->insertImage();    
                
                $id = Auth::user()->id;  
                if($this->paginate->unlockCourse($id) === true) {
                    return view('students.students', [
                        'courses' =>  $this->paginate->getCourses(),
                        'userId' => $id,
                        'userName' => $this->loginAuth->dottedText(),
                        'image' => $this->storeImage->insertImage(),
                    ]);
                } else {
                    return view('students.students', [
                        'error' => 'Verificamos que ainda não efetuou o pagamento',
                        'userId' => Auth::user()->id,
                        'userName' => $this->loginAuth->dottedText(),
                        'image' => $this->storeImage->insertImage(),
                    ]);
                }          
            break;

            case $this->loginAuth->validateUser() === "socialLogin":
                /*insere uma imagem de perfil*/
                $this->storeImage->insertSocialImage();

                $id = Session::get('id');
                /*validando o status de pagamento*/
                if($this->paginate->unlockCourse($id) === true) {
                    return view('students.students', [
                        'courses' =>  $this->paginate->getCourses(),
                        'socialId' => $this->storeImage->getSocialId(),
                        'userName' => $this->loginAuth->dottedText(),
                        'image' => $this->storeImage->insertSocialImage()
                    ]);
                } else {
                    return view('students.students', [
                        'error' => 'Verificamos que ainda não efetuou o pagamento',
                        'socialId' => $this->storeImage->getSocialId(),
                        'userName' => $this->loginAuth->dottedText(),
                        'image' => $this->storeImage->insertSocialImage()
                    ]);
                }
            break;

            default:
                return redirect()->route('user.login');
        }
    }

    /*pesquisa os cursos*/
    public function searchCourses(Request $request) 
    {
        /*validando o campo de pesquisa*/
        $validateFields = new ValidateFields();    
        $validateFields->validateInputSearch($request);
        $search = $request->search;

        /*Retornando erro caso nao encontre os cursos*/
        if($this->paginate->courses($request) === false) {
            switch($this->loginAuth->validateUser()) {
                case "userLogin":
                    return view('students.students', [
                        'userId' => Auth::user()->id,
                        'image' => $this->storeImage->insertSocialImage(),
                        'userName' => $this->loginAuth->dottedText(),
                        'error' => 'Não foi encontrado resultado para '.$request->search
                    ]);
                break;
    
                case "socialLogin":
                    return view('students.students', [
                        'socialId' => $this->storeImage->getSocialId(),
                        'image' => $this->storeImage->insertSocialImage(),
                        'userName' => $this->loginAuth->dottedText(),
                        'error' => 'Não foi encontrado resultado para '.$request->search
                    ]);
                break;
            }
        }

        /*Retornando a pesquisa*/
        switch($this->loginAuth->validateUser()) {
            case "userLogin":
                $this->storeImage->insertImage(); {                
                    return view('students.students', [
                        'userId' => Auth::user()->id,
                        'image' => $this->storeImage->insertSocialImage(),
                        'userName' => $this->loginAuth->dottedText(),
                        'courses' => $this->paginate->courses($request),
                        'search' => $search
                    ]);
                } 
            break;

            case "socialLogin":
                $this->storeImage->insertSocialImage();
                return view('students.students', [
                    'socialId' => $this->storeImage->getSocialId(),
                    'image' => $this->storeImage->insertSocialImage(),
                    'userName' => $this->loginAuth->dottedText(),
                    'courses' => $this->paginate->courses($request),
                    'search' => $search
                ]);
            break;
        }
    }

    //aula
    public function lesson(Request $request)
    {
        $paginate = new Paginate();
        switch($this->loginAuth->validateUser()) {
            case $this->loginAuth->validateUser() === "userLogin":
                return view('students.lesson', [
                    'userId' => Auth::user()->id,
                    'userName' => $this->loginAuth->dottedText(),
                    'image' => $this->storeImage->insertSocialImage(),
                    'courses' => $this->paginate->coursesLinks($request),
                    'courseInfo' => $this->paginate->getCourseInfo($request)
                ]);
            break;

            case $this->loginAuth->validateUser() === "socialLogin":
                return view('students.lesson', [
                    'socialId' => $this->storeImage->getSocialId(),
                    'userName' => $this->loginAuth->dottedText(),
                    'image' => $this->storeImage->insertSocialImage(),
                    'courses' => $this->paginate->coursesLinks($request),
                    'courseInfo' => $this->paginate->getCourseInfo($request)
                ]);
            break;

            default:
                return redirect()->route('user.login');
        }
    }

    /*exibe video aula*/
    public function getVideo(Request $request) {
        return $this->paginate->getCourseVideo($request);
    }

    public function userProfile(Request $request) 
    {   
       $this->storeImage->updateImage($request);
    }

    public function destroy(Delete $delete, Request $request, $id)
    {
        if($delete->deleteUser($request, $id) === true) {
            return "Usuário deletado com sucesso!";
        }
    }

    public function updateStudent(Update $update, Request $request) 
    {
        $validateFields = new ValidateFields();    
        
        if($validateFields->validateStudentProfile($request) === false) {
            return 'Preencha os campos corretamente!';
        }

        if($update->profileUpdate($request)) {
            return 'Dados alterado com sucesso';
        }
    }
}