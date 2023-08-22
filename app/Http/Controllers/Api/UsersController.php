<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function registerUser(Request $request){
        $external_id = $request->id;
        $username = $request->username;

        $result = $this->checkExistUser($external_id, $username);

        switch ($result->code) {
            case 300:
                $this->createUser($request);
                break;
            case 301:
                $this->updateUser($request);
                break;
            case 302:
                return $result->message;
                break;
            
            default:
                # code...
                break;
        }

    }

    public function checkExistUser($external_id, $username){
        $user = \DB::table('users')
                    ->where('is_active', 1)
                    ->where('is_deleted', 0)
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

        if(!is_null($data->last_name)){
            $tokens = explode(" ", $data->last_name);
            $first_name = $tokens[0];
            $last_name = $tokens[1];
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
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
            \Log::error($th);
            return json_encode(['success' => false, 'message' => $th->getMessage()]);
        }

        return json_encode(['success' => true, 'message' => 'Usuario creado con éxito']);
    }

    public function updateUser($data){
        $external_id = $data->id;
        $email = $data->email;
        $password = $data->password;
        $first_name = $data->first_name;
        $last_name = $data->last_name;
        $names = $data->names;
        $full_name = $data->full_name;

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
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
            \Log::error($th);
            return json_encode(['success' => false, 'message' => $th->getMessage()]);
        }

        return json_encode(['success' => true, 'message' => 'Usuario creado con éxito']);
    }
}
