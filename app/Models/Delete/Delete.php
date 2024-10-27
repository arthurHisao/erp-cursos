<?php

namespace App\Models\Delete;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use File;
use App\Models\SocialiteUser;
use App\Models\User; 
use App\Models\Lesson; 
use Illuminate\Support\Facades\Storage;

class Delete extends Model
{
    use HasFactory;

    public function __construct() 
    {
        $this->lesson = new Lesson();
        $this->user = new User();
        $this->socialiteUser = new SocialiteUser();
    }


    public function deleteUser($request, $id)
    {
        //select 
        $select = SocialiteUser::select('social_user_id')->where(['id' => $id])->first();
        
        if($select) {
            $del = $this->socialiteUser->destroy($id);
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $userImg = "user-profile/socialite".$id;
            File::deleteDirectory($userImg);
            return true;
        } else {
            $del = $this->user->destroy($id);
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $userImg = "user-profile/".$id;
            File::deleteDirectory($userImg);
            return true;
        }   
    }

    public function deleteUploadedVideos($request, $id)
    {
        $select = Lesson::select('video_path')->where(['id' => $id])->first();
 
        if($select) {
            /*deletando o video da base de dados*/
            $delete = Lesson::where(['id' => $id ])->delete();
            
            /*deletando o video na pasta local */
            unlink(storage_path('app/'.$select->video_path));
            return true;
        }
    }
}
