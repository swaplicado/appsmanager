<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserPermissions;
use App\Utils\AppsUtils;
use App\Utils\PermissionsUtils;
use Illuminate\Http\Request;

class UsersVsPermissionsController extends Controller
{
    public function index(){
        $lUsers = User::join('adm_user_apps as up', 'up.user_id', '=', 'users.id')
                    ->join('adm_apps as a', 'a.id_app', '=', 'up.app_id')
                    ->where('users.is_active', 1)
                    ->where('users.is_deleted', 0)
                    ->select(
                        'users.id',
                        'a.id_app',
                        'users.username',
                        'users.full_name',
                        'a.name'
                    )
                    ->get()
                    ->toArray();

        foreach ($lUsers as &$subArray) { // se pasa por referencia para modificar el array original
            $subArray = array_values($subArray); // se obtiene un array simple con los valores del sub-array
        }
        unset($subArray);

        $lApps = AppsUtils::getApps()->map(function ($item){
            return [
                'id' => $item['id_app'],
                'text' => $item['name'],
            ];
        });

        $lApps->prepend(['id' => -1, 'text' => 'appsmanager']);
        $lApps->prepend(['id' => 0, 'text' => 'Todos']);

        return view('usersVsPermissions.userPermission')->with('lUsers', $lUsers)
                                                        ->with('lApps', $lApps);
    }

    public function getUserPermission(Request $request){
        try {
            $lPermissions = PermissionsUtils::getUserPermission($request->id_user)->toArray();
            
            $json = json_encode($lPermissions);
            // Decode the JSON string into an array of arrays
            $lPermissions = json_decode($json, true);
            foreach ($lPermissions as &$subArray) { // se pasa por referencia para modificar el array original
                $subArray = array_values($subArray); // se obtiene un array simple con los valores del sub-array
            }
            unset($subArray);
        } catch (\Throwable $th) {
            \Log::error($th);
            return json_encode(['success' => false, 'message' => $th->getMessage(), 'icon' => 'error']);
        }

        return json_encode(['success' => true, 'lPermissions' => $lPermissions]);
    }
    public function create(Request $request){

    }

    public function update(Request $request){
        try {
            $id_permission = $request->id_permission;
            $is_active = $request->is_active;
            $id_app = $request->id_app;
            $id_user = $request->id_user;
            $id_rol = $request->id_rol;

            \DB::beginTransaction();

            $oPermission = Permission::where('id_permission', $id_permission)->first();

            if(is_null($oPermission)){
                \DB::rollBack();
                return json_encode([
                    'success' => false,
                    'message' => 'Error: permiso no encontrado',
                    'type' => 'error',
                    'checkbox' => 'permission'.$id_permission,
                    'checkbox_status' => !$is_active
                ]);
            }

            $oUserPermission = UserPermissions::where('permission_id', $id_permission)
                                                ->where('user_id', $id_user)
                                                ->where('app_n_id', $id_app)
                                                ->first();

            $RolPermission = \DB::table('adm_roles_permissions')
                                ->where('app_n_id', $id_app)
                                ->where('role_id', $id_rol)
                                ->where('permission_id', $id_permission)
                                ->first();

            if(!is_null($oUserPermission)){
                if($is_active){
                    if(!is_null($RolPermission)){
                        $oUserPermission->delete();
                    }else{
                        $oUserPermission = new UserPermissions();
                        $oUserPermission->app_n_id = $id_app;
                        $oUserPermission->user_id = $id_user;
                        $oUserPermission->permission_id = $oPermission->id_permission;
                        $oUserPermission->is_blocked = 0;
                        $oUserPermission->save();
                    }
                }else{
                    if(!is_null($RolPermission)){
                        $oUserPermission->is_blocked = 1;
                        $oUserPermission->update();
                    }else{
                        $oUserPermission->delete();
                    }
                }
            }else{
                if($is_active){
                    if(is_null($RolPermission)){
                        $oUserPermission = new UserPermissions();
                        $oUserPermission->app_n_id = $id_app;
                        $oUserPermission->user_id = $id_user;
                        $oUserPermission->permission_id = $oPermission->id_permission;
                        $oUserPermission->is_blocked = 0;
                        $oUserPermission->save();
                    }
                }else{
                    if(!is_null($RolPermission)){
                        $oUserPermission = new UserPermissions();
                        $oUserPermission->app_n_id = $id_app;
                        $oUserPermission->user_id = $id_user;
                        $oUserPermission->permission_id = $oPermission->id_permission;
                        $oUserPermission->is_blocked = 1;
                        $oUserPermission->save();
                    }
                }
            }

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
            if(!is_null($oPermission)){
                return json_encode([
                    'success' => false,
                    'message' => $oPermission->key_code.': '.$oPermission->level.' Error',
                    'type' => 'error',
                    'checkbox' => 'permission'.$id_permission,
                    'checkbox_status' => !$is_active
                ]);
            }else{
                return json_encode([
                    'success' => false,
                    'message' => 'Error no se encontro el permiso',
                    'type' => 'error',
                    'checkbox' => 'permission'.$id_permission,
                    'checkbox_status' => !$is_active
                ]);
            }
        }
        return json_encode([
            'success' => true,
            'message' => $oPermission->key_code.': '.$oPermission->level.($is_active ? ' Asignado' : ' Eliminado'),
            'type' => 'success'
        ]);
    }


    public function delete(Request $request){

    }
}
