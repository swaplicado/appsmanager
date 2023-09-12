<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\FilesUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(){
        $oUser = \Auth::user();

        return view('profile.profile')->with('oUser', $oUser);
    }

    public function updateProfile(Request $request){
        try {
            $email = $request->email;
            $changePass = filter_var($request->changePass, FILTER_VALIDATE_BOOLEAN);
            $password = $request->password;
            $confirmPassword = $request->confirmPassword;
            $imgProfile = $request->file('imgProfile');

            if($changePass){
                if($password != $confirmPassword){
                    return json_encode(['success' => false, 'message' => "El campo 'Contraseña' y 'Confirmar contraseña' deben coincidir", 'icon' => 'error']);
                }
    
                $password = \DB::select(\DB::raw("SELECT PASSWORD('$request->password') AS password_result"))[0]->password_result;
            }

            if(!is_null($imgProfile)){
                $result = FilesUtils::validateFile($imgProfile, ['image/png', 'image/jpeg'], '20 MB');
                if(!$result[0]){
                    return json_encode(['success' => false, 'message' => $result[1], 'icon' => 'error']);
                }
    
                if(!is_null(\Auth::user()->img_path)){
                    if (\File::exists(public_path(\Auth::user()->img_path))) {
                        \File::delete(public_path(\Auth::user()->img_path));
                    } else {
                        return json_encode(['success' => false, 'message' => 'No se puedo cargar la imagen', 'icon' => 'error']);
                    }
                }
                
                $fileName = \Auth::user()->username.'_img_profile.'.$imgProfile->extension();
                $imgProfile->move(public_path('ImagesProfiles'), $fileName);
                $img_path = 'ImagesProfiles/' . $fileName;
            }
            
            \DB::beginTransaction();

            $oUser = User::findOrFail(\Auth::user()->id);
            $oUser->email = $email;
            
            if(!is_null($imgProfile)){
                $oUser->img_path = $img_path;
            }

            if($changePass){
                $oUser->password = \Hash::make($password);
            }

            $oUser->update();

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
            return json_encode(['success' => false, 'message' => $th->getMessage(), 'icon' => 'error']);
        }

        return json_encode(['success' => true, 'message' => 'Actualizado con éxito', 'icon' => 'success']);
    }
}
