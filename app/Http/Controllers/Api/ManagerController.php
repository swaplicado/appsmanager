<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\UserRoles;
use App\Models\UsersTypesusers;
use Illuminate\Http\Request;
use App\Models\User;

class ManagerController extends Controller
{
    public function registerUser(Request $request){
        $external_id = $request->id;
        $username = $request->username;

        $result = $this->checkExistUser($external_id, $username);

        $response = null;
        switch ($result->code) {
            case 300:
                $response = $this->createUser($request);
                break;
            case 301:
                $response = $this->updateUser($request);
                break;
            case 302:
                $response = $result->message;
                break;
            
            default:
                # code...
                break;
        }

        return response()->json($response, json_decode($response)->code);
    }

    public function checkExistUser($external_id, $username){
        $user = \DB::table('users')
                    ->where('is_active', 1)
                    ->where('is_deleted', 0)
                    ->where('external_id_n', '!=', null)
                    ->where('external_id_n', $external_id)
                    ->first();

        if(!is_null($user)){
            $result = new \stdClass;
            $result->exist = true;
            $result->code = 301;
            $result->message = 'Ya existe el usuario';

            return $result;
        }

        $user = \DB::table('users')
                    ->where('is_active', 1)
                    ->where('is_deleted', 0)
                    ->where('username', $username)
                    ->first();

        if(!is_null($user)){
            $result = new \stdClass;
            $result->exist = true;
            $result->code = 302;
            $result->message = 'Ya existe un usuario registrado con el mismo nombre de usuario';

            return $result;
        }

        $result = new \stdClass;
        $result->exist = false;
        $result->code = 300;
        $result->message = 'El usuario no existe';

        return $result;
    }

    public function createUser($data){
        $external_id = $data->id;
        $username = $data->username;
        $email = $data->email;
        $password = $data->password;
        $lApps = $data->lApps;

        if(!is_null($data->last_name)){
            $tokens = explode(" ", $data->last_name);
            $first_name = count($tokens) > 0 ? $tokens[0] : $username;
            $last_name = count($tokens) > 1 ? $tokens[1] : $username;
        }else{
            $first_name = $username;
            $last_name = $username;
        }

        $names = $data->names != null ? $data->names : $username;
        $full_name = $data->full_name != null ? $data->full_name : $username;

        try {
            \DB::beginTransaction();
            $oUser = new User();
            $oUser->external_id_n = $external_id;
            $oUser->username = $username;
            $oUser->email = $email;
            $oUser->password = \Hash::make($password);
            $oUser->first_name = $first_name;
            $oUser->last_name = $last_name;
            $oUser->names = $names;
            $oUser->full_name = $full_name;
            $oUser->is_active = 1;
            $oUser->is_deleted = 0;
            $oUser->created_by = 1;
            $oUser->updated_by = 1;
            $oUser->save();

            if(count($lApps) > 0){
                $this->setUserApps($oUser->id, $lApps);
            }

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
            \Log::error($th);
            return json_encode(['success' => false, 'message' => $th->getMessage(), 'code' => 500]);
        }

        return json_encode(['success' => true, 'oUser' => $oUser, 'message' => 'Usuario creado con éxito', 'code' => 200]);
    }

    public function updateUser($data){
        $external_id = $data->id;
        $username = $data->username;
        $email = $data->email;
        $password = $data->password;
        $lApps = $data->lApps;

        if(!is_null($data->last_name)){
            $tokens = explode(" ", $data->last_name);
            $first_name = count($tokens) > 0 ? $tokens[0] : $username;
            $last_name = count($tokens) > 1 ? $tokens[1] : $username;
        }else{
            $first_name = $username;
            $last_name = $username;
        }

        $names = $data->names != null ? $data->names : $username;
        $full_name = $data->full_name != null ? $data->full_name : $username;

        try {
            \DB::beginTransaction();
                $oUser = User::where('external_id_n', $external_id)
                                ->where('is_active', 1)
                                ->where('is_deleted', 0)
                                ->firstOrFail();
                                
                $oUser->email = $email;
                $oUser->password = \Hash::make($password);
                $oUser->first_name = $first_name;
                $oUser->last_name = $last_name;
                $oUser->names = $names;
                $oUser->full_name = $full_name;
                $oUser->is_active = 1;
                $oUser->is_deleted = 0;
                $oUser->updated_by = 1;
                $oUser->update();

                if(count($lApps) > 0){
                    $this->setUserApps($oUser->id, $lApps);
                }
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
            \Log::error($th);
            return json_encode(['success' => false, 'message' => $th->getMessage(), 'code' => 500]);
        }

        return json_encode(['success' => true, 'oUser' => $oUser, 'message' => 'Usuario actualizado con éxito', 'code' => 200]);
    }

    public function setUserApps($user_id, $lApps){
        $lApps = json_encode($lApps);
        $lApps = json_decode($lApps);
        foreach($lApps as $app){
            $userApp = UserApp::where('user_id', $user_id)->where('app_id', $app->id_app)->first();
            if(!is_null($userApp) && !$app->assigned){
                $userApp->delete();
            }else if(is_null($userApp) && $app->assigned){
                $userApp = new UserApp();
                $userApp->user_id = $user_id;
                $userApp->app_id = $app->id_app;
                $userApp->save();
            }

            if($app->assigned){
                $this->setUserType(3, $user_id, $app->id_app);
                switch ($app->id_app) {
                    case 1:
                        $this->setUserRole(2, $user_id, $app->id_app);
                        break;
                    case 2:
                        $this->setUserRole(3, $user_id, $app->id_app);
                        break;
                    
                    default:
                        break;
                }
            }
        }
    }

    public function getApps(){
        $lApps = \DB::table('adm_apps AS a')
                    ->where('a.is_active', true)
                    ->select(
                        'name',
                        'app_url',
                        'description'
                    )
                    ->get();

        return $lApps;
    }

    public function getUserApps(Request $request){
        try {
            $external_id = $request->id;
    
            $oUser = \DB::table('users')
                        ->where('external_id_n', '!=', null)
                        ->where('external_id_n', $external_id)
                        ->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->first();
    
            $assignedlApps = collect([]);
            $appsIds = [];
            if(!is_null($oUser)){
                $assignedlApps = \DB::table('users as u')
                                    ->join('adm_user_apps as ua', 'ua.user_id', '=', 'u.id')
                                    ->join('adm_apps as ap', 'ap.id_app', '=', 'ua.app_id')
                                    ->where('u.id', $oUser->id)
                                    ->where('ap.is_active', 1)
                                    ->select(
                                        'ap.id_app',
                                        'ap.name',
                                        'ap.description'
                                    )
                                    ->selectRaw('true as assigned')
                                    ->get();
    
                $appsIds = $assignedlApps->pluck('id_app')->toArray();
            }
            $unassignedlApps = \DB::table('adm_apps')
                                    ->whereNotIn('id_app', $appsIds)
                                    ->where('is_active', 1)
                                    ->select(
                                        'adm_apps.id_app',
                                        'adm_apps.name',
                                        'adm_apps.description'
                                    )
                                    ->selectRaw('false as assigned')
                                    ->get();
    
            $lApps = $unassignedlApps->merge($assignedlApps);
        } catch (\Throwable $th) {
            return response()->json(json_encode(['success' => false, 'message' => $th->getMessage()]), 500);
        }

        return response()->json(['success' => true, 'lApps' => $lApps], 200);
    }

    public function setUserType($typeuser_id, $user_id, $app_id){
        $userType = UsersTypesusers::where('user_id', $user_id)->where('app_id', $app_id)->first();
        if(is_null($userType)){
            $userType = new UsersTypesusers();
            $userType->user_id = $user_id;
            $userType->app_id = $app_id;
            $userType->typeuser_id = $typeuser_id;
            $userType->save();
        }else{
            $userType->typeuser_id = $typeuser_id;
            $userType->update();
        }
    }

    public function setUserRole($role_id, $user_id, $app_id){
        $userRol = UserRoles::where('user_id', $user_id)->where('app_n_id', $app_id)->first();
        if(is_null($userRol)){
            $userRol = new UserRoles();
            $userRol->app_n_id = $app_id;
            $userRol->user_id = $user_id;
            $userRol->role_id = $role_id;
            $userRol->save();
        }else{
            $userRol->role_id = $role_id;
            $userRol->update();
        }
    }
}
