<?php

namespace App\Models\Paginate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAdmin;
use App\Models\User;
use App\Models\SocialiteUser;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Auth\LoginAuth;


class Paginate extends Model
{
    use HasFactory;

    private $paginateValue;

    /*exibe os links das video aulas na pagina de licao*/
    public function coursesLinks($request)
    {
        $max = 5;
        return DB::select('SELECT * FROM `lessons` ORDER BY `id` asc  LIMIT ?, ?', [$request->segment(3), $max]);
        // return DB::table('lessons')
        //     ->take($request->segment(3))
        //     ->skip(1)
        //     ->get();
    }

    /*exibe os cursos nas paginas cursos e aluno*/
    public function getCourses() 
    {
        return Lesson::paginate(10);    
    }

    /*exibe o detalhes do curso*/
    public function getCoursesDetails($request) 
    {
        return DB::table('lessons')->select('video_description', 'title', 'video_thumbnail','category','user_name')    
            ->where(['video_link_name' => $request->segment(2)])
            ->first();
    }


    /*exibe foto do video*/
    public function getCourseInfo($request) {
        $this->genURLToken();
        return DB::table('lessons')->select('video_thumbnail', 'title', 'video_name')
            ->where(['video_link_name' => $request->segment(2)])
            ->first();
    }

    /*token do link da video aula*/
    private function genURLToken()
    {
        $token = strval(bin2hex(random_bytes(10)));
        Session::put('url-token', $token);
    }

    /*exibe a video aula*/
    public function getCourseVideo($request) {             
        $path = DB::table('lessons')->select('video_path')->where(['video_link_name' => $request->segment(2)])->first();
        $videoLocation = Storage::disk('local')->get($path->video_path);
        $response = Response::make($videoLocation, 200);
        $response->header('Content-Type', 'video/mp4');
        return $response;
    }

    /*pesquisa os cursos*/
    public function courses($request)
    {   
        $select = DB::table('lessons')->where('video_name', 'like', '%' . $request->search . '%')->paginate(10);   
        
        if($select->isEmpty()) {
            return false;
        }
        return $select;
    }

    /*metodo de verificar o status do pagamento*/
    public function unlockCourse($id) {   
        $select = User::select('payment_status')->where(['id' => $id])->first();
        if(isset($select->payment_status) && $select->payment_status !== "NULL") {
            return true;
        } else {
            $selectSocialite = SocialiteUser::select('payment_status')->where(['social_user_id' => $id])->first();    
            if(isset($selectSocialite->payment_status) && $selectSocialite->payment_status !== "NULL") {
                return true;
            }
        }  
    }

    /*verifica se possui usuario cadastrado ao gerar boleto*/
    public function checkUser($formValue) 
    {
        /*instanciando a classe de login*/
        $loginAuth = new LoginAuth();

        /*tratamento cpf */
        $newCPF = str_replace(['.','-'], '', trim($formValue->inputCPF));         

        switch($loginAuth->validateUser()) {
            case $loginAuth->validateUser() === "userLogin":
                /*selecionando os usuarios*/
                $select = User::select('name','cpf')
                    ->where(['name' => $formValue->inputName])
                    ->where(['cpf' => $newCPF])->first();
                if($select) {
                    return true;
                }
            break;

            case $loginAuth->validateUser() === "socialLogin":
                /*selecionando os usuarios socialite */
                $selectSocialite = SocialiteUser::select('social_user_id')
                    ->where(['name' => $formValue->inputName])  
                    ->where(['cpf' => $newCPF])->first();
                
                if($selectSocialite) {
                    return true;
                /*} else {
                    /*insere cpf caso nao encontrar*/
                    /*$update = SocialiteUser::where('social_user_id', Session::get('id'))
                       ->update(['cpf' => $newCPF]);
                    
                    if($update) {
                        return true;
                    }*/
                }
            break;
        }
    }

    /*pagina do administrador*/
    public function adminDashboard($value) 
    {
        return UserAdmin::paginate($value);    
    }

    /*exibe os estudantes*/
    public function listStudents($value) 
    {
        return User::paginate($value);    
    }

    public function listSocialiteStudents($value)
    {
        return SocialiteUser::paginate($value);          
    }

    /*altera a permisao do usuario */
    public function listUsersPermission($urlID)
    {
        return UserAdmin::select('id','name','email')->where(['id' => $urlID])->first();  
    }

    /*retorna a informacao de pagamento do usuario */
    public function listStudentPermission($urlID)
    {
        return User::select('id','name','email')->where(['id' => $urlID])->first();  
    }

    /*retorna a informacao de pagamento do usuario logado com rede social */
    public function listSocialitePermission($urlID)
    {
        return SocialiteUser::select('id','name','email')->where(['id' => $urlID])->first();  
    }

    public function adminVideoPaginate($value)
    {
        return Lesson::where(['user_name' => Auth::guard('userAdmin')->user()->name])->paginate($value);
    }

    public function getVideoID($request) 
    {
        return Lesson::select('id')->where(['id' => $request->segment(4)])->first();   
    }

    public function adminProfile()
    {
        return UserAdmin::select('permission')->where(['id' => Auth::guard('userAdmin')->user()->id])->first();
    } 
}