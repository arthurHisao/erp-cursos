<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use App\Models\SocialiteUser;
use App\Models\Lesson;
use App\Models\Auth\LoginAuth;
use App\Models\UserAdmin;
use App\Models\Delete\Delete;
use App\Models\Image\StoreImage;
use App\Models\Paginate\Paginate;
use App\Models\Update\Update;
use App\Models\Fields\ValidateFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;
use Carbon\Carbon;


class UserAdminController extends Controller
{
    private $paginate;
    private $update;
    private $userAdmin;
    private $loginAuth;
    private $userImage;
    private $storeImage;

    public function __construct() 
    {
        $this->paginate = new Paginate();
        $this->update = new Update();
        $this->userAdmin = new userAdmin();
        $this->loginAuth = new LoginAuth();
        $this->userImage = new UserImage();
        $this->storeImage = new StoreImage();
    }

    /*lista todos os usuarios*/
    public function listUsers()
    {
        if($this->storeImage->insertAdminImage() === "inserted") {
            return view('admin.adminDashboard', [
                'userId' => Auth::guard('userAdmin')->user()->id,
                'image' => $this->storeImage->insertAdminImage(),
                'users' => $this->paginate->adminDashboard(15)
            ]);
        }
        
        return view('admin.adminDashboard', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'image' => $this->storeImage->insertAdminImage(),
            'users' => $this->paginate->adminDashboard(15)
        ]);
    }

    /*lista todos os estudantes*/
    public function listStudents() 
    {
        if($this->storeImage->insertAdminImage() === "inserted") {
            return view('admin.permission.userStudent', [
                'userId' => Auth::guard('userAdmin')->user()->id,
                'image' => $this->storeImage->insertAdminImage(),
                'users' => $this->paginate->listStudents(15)
            ]);
        }
        
        return view('admin.permission.userStudent', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'image' => $this->storeImage->insertAdminImage(),
            'users' => $this->paginate->listStudents(15)
        ]);
    }

    /*lista os estudantes*/
    public function listSocialiteStudents() 
    {
        if($this->storeImage->insertAdminImage() === "inserted") {
            return view('admin.permission.userStudent', [
                'userId' => Auth::guard('userAdmin')->user()->id,
                'image' => $this->storeImage->insertAdminImage(),
                'users' => $this->paginate->listSocialiteStudents(15)
            ]);
        }
        
        return view('admin.permission.userStudent', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'image' => $this->storeImage->insertAdminImage(),
            'users' => $this->paginate->listSocialiteStudents(15)
        ]);
    }

    /*Editando permissao dos usuarios interno*/
    public function editPermission(Request $request)
    {
        $urlID = $request->segment(3);
       
        return view('admin.permission.userPermission', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'image' => $this->storeImage->insertAdminImage(),
            'users' =>  $this->paginate->listUsersPermission($urlID)
        ]);
    }

    /*Editando permissao dos alunos*/
    public function editStudentPermission(Request $request)
    {
        $urlID = $request->segment(4);
        
        return view('admin.permission.studentPermission', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'image' => $this->storeImage->insertAdminImage(),
            'users' =>  $this->paginate->listStudentPermission($urlID)
        ]);
    }

    /*Editando permissao dos alunos logados com redes sociais*/
    public function editSocialitePermission(Request $request)
    {
        $urlID = $request->segment(5);
        
        return view('admin.permission.studentPermission', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'image' => $this->storeImage->insertAdminImage(),
            'users' =>  $this->paginate->listSocialitePermission($urlID)
        ]);
    }

    public function adminProfile(Request $request) 
    {   
        return view('admin.profile.adminProfile', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'image' => $this->storeImage->insertAdminImage(),
            'users' => $this->paginate->adminProfile()
        ]);
    }


    public function updateAdmin(Request $request)
    {
        $validateFields = new ValidateFields();    
        if($validateFields->validateAdminProfile($request) === false) {
            return 'Preencha os campos corretamente!';
        }

        if($this->update->adminProfileUpdate($request)) {
            return 'Dados alterado com sucesso';
        }
    }

    public function userProfile(Request $request) 
    {   
       $this->storeImage->updateImage($request);
    }
    

    public function uploadPage()
    {
        return view('admin.upload.uploadForm', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'image' => $this->storeImage->insertAdminImage(),
        ]);
    }

    public function videoDetails()
    {
        return view('admin.uploadedDescription', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'image' => $this->storeImage->insertAdminImage(),
            'lessons' => $this->paginate->adminVideoPaginate(15)
        ]);
    }

    public function editVideos(Request $request)
    {
        return view('admin.editVideos', [
            'userId' => Auth::guard('userAdmin')->user()->id,
            'videoId' => $this->paginate->getVideoID($request),
            'image' => $this->storeImage->insertAdminImage(),
        ]);
    }

    public function deleteVideos(Delete $delete, Request $request)
    {
        $id = $request->id;
        if($delete->deleteUploadedVideos($request, $id) === true) {
            return 'vídeo deletado com sucesso!';
        }
    }

    /*funcao de upload de videos*/
    public function upload(Request $request) 
    {
        return $this->update->uploadVideo($request);
          
    }

    /*funcao para alterar permissao */
    public function updatePermission(Request $request) 
    {
       return $this->update->permission($request);
    }

    /*alterando o status do pagamento do aluno*/
    public function updatePaymentStatus(Request $request) 
    {
       return $this->update->paymentStatus($request);
    }


    public function destroy(Request $request)
    {
        $id = $request->id;
        $del = $this->userAdmin->destroy($id);
        $userImg = "user-profile/".$id;
        File::deleteDirectory($userImg);
        return "Usuário deletado com sucesso!";
    }

    /*Atualiza a descricao do video*/
    public function updateVideoDescription(ValidateFields $validateFields, Request $request)
    {   
        if($validateFields->validateVideoDescription($request) === false) {
            return "Verifique se digitou os campos corretamente";
        }
        return $this->update->updateDescription($request);
    }

    /*Upload da imagem do video*/
    public function videoThumbnail(StoreImage $storeImage, Request $request) 
    {
        $videoThumbnail = $request->file('file');
        $videoId = json_decode($request->id);
        
        if($storeImage->moveThumbnails($videoThumbnail, $videoId) === true) {
            return "Upload da imagem concluido com sucesso!";
        }
        return 'Ocorreu um erro tente novamente';
    }
}