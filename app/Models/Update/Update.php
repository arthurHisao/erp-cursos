<?php

namespace App\Models\Update;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SocialiteUser;
use App\Models\UserAdmin;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use File;
use Carbon\Carbon;

class Update extends Model
{
    use HasFactory;

    /*atualizando os dados do usuario*/
    public function profileUpdate ($request)
    {
        $form = json_decode($request->formValue);

        $update = User::where('id', Auth::user()->id)
        ->update([
            'name' => ucfirst($form->inputName),
            'email' => $form->inputEmail
        ]);
        return $update;
    }

    /*atualizando os dados do usuario administrador*/
    public function adminProfileUpdate ($request)
    {
        $form = json_decode($request->formValue);

        $update = UserAdmin::where('id', Auth::guard('userAdmin')->user()->id)
        ->update([
            'name' => ucfirst($form->inputName),
            'email' => $form->inputEmail
        ]);
        return $update;
    }

    public function uploadVideo($request)
    {
        $files = $request->file('file');
        $size = json_decode($request->fileSize);
        $allowed = ['webm','mov','mp4'];
        $total = 0;

        foreach($files as $file) {
            if(in_array($file->getClientOriginalExtension(), $allowed)) {
                $total += $file->getSize();

                try {
                    //prevenindo duplicidade de mesmo registro
                    $select = DB::table('lessons')->select('video_name')
                        ->where('video_name', $file->getClientOriginalName())
                        ->first();

                    if(!$select) {
                        Storage::disk('local')->putFileAs('uploads/'.Auth::guard('userAdmin')->user()->id, $file, $file->getClientOriginalName());                
                        
                            DB::beginTransaction();
                            DB::table('lessons')->insert([
                                'title' => '-',
                                'video_name' =>  $file->getClientOriginalName(),
                                'video_description' => '-',
                                'video_path' => 'uploads/'.Auth::guard('userAdmin')->user()->id .'/'.$file->getClientOriginalName(),
                                'video_link_name' => '-', 
                                'category' => '-',
                                'video_thumbnail' => '/assets/images/camera.png',
                                'user_name' => Auth::guard('userAdmin')->user()->name,
                                'created_at' => Carbon::now(),
                            ]);
                            DB::commit();
                            if($size === $file->getSize()) {
                                return "Arquivo movido com sucesso";
                            }
                    } else {
                        return "O nome ".$select->video_name." já está em uso tente alterar o nome";
                    }   
                } catch(Exception $e) {
                    DB::rollback();
                    return $e->getMessage();
                }
            }
        }
    }

    public function permission($request) 
    {
        $ajaxVal = json_decode($request->value);
        UserAdmin::where('id', $ajaxVal->id)->update(['permission' => $ajaxVal->permission]);
        return "Permissão de usuário alterado com sucesso!";
    }

    public function paymentStatus($request) 
    {
        $ajaxVal = json_decode($request->value);
        $user = User::where('id', $ajaxVal->id)->update(['payment_status' => $ajaxVal->status]);
        if($user) {
            return "Status do pagamento alterado com sucesso!";
        } else {
            $socialite = SocialiteUser::where('id', $ajaxVal->id)->update(['payment_status' => $ajaxVal->status]);
            
            return "Status do pagamento alterado com sucesso!"; 
        }
    }

 
    public function updateDescription($request)
    {
        $video = json_decode($request->values);
        Lesson::where('id', $video->id)
            ->update([
                'title' => $video->title,
                'video_link_name' => $video->link,
                'video_description' => $video->description,
                'category' => $video->categories    
            ]);
        return "Descrição e categoria atualizado com sucesso!";
    }
}
