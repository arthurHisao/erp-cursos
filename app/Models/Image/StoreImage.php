<?php

namespace App\Models\image;

use App\Models\User; 
use App\Models\UserImage;
use App\Models\SocialiteUser;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use File;

class StoreImage extends Model
{
    use HasFactory;

    private $userId;
    private $socialId;
    private $select;


    /*cria uma nova pasta com a imagem padrao*/
    private function newProfile($id)  
    {
        if(!File::exists('user-profile/'.$id)) {
            File::makeDirectory('user-profile/'.$id);
            File::copy(public_path('assets/images/no-user.png'), public_path('user-profile/'.$id.'/no-user.png'));
        }
    }

    public function insertImage() 
    {   
        $this->userId = Auth::user()->id;    

        /*verificando se existe nome do arquivo no banco de dados*/
        $this->select = UserImage::select("file_name")->where(["user_id" => $this->userId])->first();        

        if(!$this->select) {       
            $this->newProfile($this->userId);               
          
            $newImage = UserImage::insert([
                'user_id' =>  $this->userId, 
                'file_name' => 'no-user.png',
                'created_at' => Carbon::now(),
            ]);
            return "inserted";
        }
        /*retorna nome da imagem*/
        return $this->select;
    }

    /*obtendo o id da tabela*/
    public function getSocialId() {
        $this->socialId = Session::get('id');
        $this->select = SocialiteUser::select('id')->where(["social_user_id" => $this->socialId])->first();
        
        if(!$this->select) {
            return null;
        }
        return $this->select->id;
    }

    /*cria uma nova pasta com a imagem padrao*/
    private function newSocialProfile($id)  
    {
        $path = 'user-profile/socialite/';

        if(!File::exists($path)) {
            File::makeDirectory($path);
            File::makeDirectory($path .$id);
            File::copy(public_path('assets/images/no-user.png'), public_path($path .$id. '/no-user.png'));
        } else if (!File::exists($path .$id)) {
            File::makeDirectory($path .$id);
            File::copy(public_path('assets/images/no-user.png'), public_path($path .$id. '/no-user.png'));
        }
    }

    public function insertSocialImage() 
    {
        //$this->socialId = $this->getSocialId();
        $userImage = UserImage::select("file_name")->where(["social_user_id" => $this->getSocialId()])->first();
            
            if(!$userImage) {
                $this->newSocialProfile($this->getSocialId());               
               
                $newImage = UserImage::insert([ 
                    'social_user_id' =>  $this->getSocialId(), 
                    'file_name' => 'no-user.png',
                    'created_at' => Carbon::now(),
                ]);
                return "inserted";
            }
            return $userImage;
    }

    private function newAdminProfile($id)  
    {
        if(!File::exists('user-profile/'.$id)) {
            File::makeDirectory('user-profile/'.$id);
            File::copy(public_path('assets/images/no-user.png'), public_path('user-profile/'.$id.'/no-user.png'));
        }
    }

    public function insertAdminImage() 
    {
        $this->userId = Auth::guard('userAdmin')->user()->id;
        $userImage = UserImage::select("file_name")->where(["admin_id" => $this->userId])->first();
            
            if(!$userImage) {
                $this->newAdminProfile($this->userId);               
               
                $newImage = UserImage::insert([ 
                    'admin_id' =>  $this->userId, 
                    'file_name' => 'no-user.png',
                    'created_at' => Carbon::now(),
                ]);
                return "inserted";
            }
            return $userImage;
    }

    public function updateImage($request)
    {
        //update do nome da imagem
        if(Auth::check()) {
            $this->userId = Auth::user()->id;  
            $this->select = UserImage::select('file_name')->where(["user_id" => $this->userId])->first();

            switch($this->select) {
                case $this->select->file_name === "no-user.png":
                    $file = $request->file('file');
                    $fileName = uniqid() .'.'. $file->getClientOriginalExtension();
                    $file->move(public_path('user-profile/'.$this->userId), $fileName);
                    UserImage::where('user_id', $this->userId)->update(['file_name' => $fileName]);
                    exit('Imagem atualizado com suceso!');
                break;

                default:
                    $file = $request->file('file');
                    $fileName = $this->select->file_name;
                    $file->move(public_path('user-profile/'.$this->userId), $fileName);
                    UserImage::where('user_id', $this->userId)->update(['file_name' => $fileName]);
                    exit('Imagem atualizado com suceso!');
            }
        } else if(Auth::guard('userAdmin')->check()) {
            $this->userId = Auth::guard('userAdmin')->user()->id;  
            $this->select = UserImage::select('file_name')->where(["admin_id" => $this->userId])->first();

            switch($this->select) {
                case $this->select->file_name === "no-user.png":
                    $file = $request->file('file');
                    $fileName = uniqid() .'.'. $file->getClientOriginalExtension();
                    $file->move(public_path('user-profile/'.$this->userId), $fileName);
                    UserImage::where('admin_id', $this->userId)->update(['file_name' => $fileName]);
                    exit('Imagem atualizado com suceso!');
                break;

                default:
                    $file = $request->file('file');
                    $fileName = $this->select->file_name;
                    $file->move(public_path('user-profile/'.$this->userId), $fileName);
                    UserImage::where('admin_id', $this->userId)->update(['file_name' => $fileName]);
                    exit('Imagem atualizado com suceso!');
            }
        } else {
            $this->select = UserImage::select('file_name')->where(["social_user_id" => $this->getSocialId()])->first();
           
            switch($this->select) {
                case $this->select->file_name === "no-user.png":
                    $file = $request->file('file');
                    $fileName = uniqid() .'.'. $file->getClientOriginalExtension();
                    $file->move(public_path('user-profile/socialite/'.$this->getSocialId()), $fileName);
                    UserImage::where('social_user_id', $this->getSocialId())->update(['file_name' => $fileName]);
                    exit('Imagem atualizado com suceso!');
                break;

                default:
                    $file = $request->file('file');
                    $fileName = $this->select->file_name;
                    $file->move(public_path('user-profile/socialite/'.$this->getSocialId()), $fileName);
                    UserImage::where('social_user_id', $this->getSocialId())->update(['file_name' => $fileName]);
                    exit('Imagem atualizado com suceso!');                
            }
        }
    }
    
    /*pagina do administrador*/
    public function moveThumbnails($videoThumbnail, $videoId) 
    {          

        $this->select = Lesson::select('video_thumbnail')->where(["id" => $videoId])->first();

        if($this->select) {     
            //movendo a imagem do video para a pasta
            $this->userId = Auth::guard('userAdmin')->user()->id;      
            $this->createFolder($this->userId);
       
            $thumbnailName = uniqid() .'.'. $videoThumbnail->getClientOriginalExtension();
            $destination = '/videos/' .$this->userId;

            $videoThumbnail->move(public_path($destination), $thumbnailName);
            
            Lesson::where('id', $videoId)
                ->update([
                    'video_thumbnail' => $destination . '/' . $thumbnailName 
                ]);
            return true;
        } 
    }

    /*criando uma nova pasta para armazenar imagens das video aulas*/
    private function createFolder($userId)  
    {
        if(!File::exists('videos/'.$userId)) {
            File::makeDirectory('videos/'.$userId);
        } 
    }

    
}
