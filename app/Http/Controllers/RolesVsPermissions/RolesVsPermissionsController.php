<?php

namespace App\Http\Controllers\RolesVsPermissions;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Utils\AppsUtils;
use App\Utils\RolesVsPermissionsUtils;
use Illuminate\Http\Request;

class RolesVsPermissionsController extends Controller
{
    public function index(){
        $lRoles = Role::leftJoin('adm_apps as a', 'a.id_app', '=', 'adm_roles.app_n_id')
                    ->where('is_deleted', 0)
                    ->select(
                        'id_role',
                        'id_app',
                        'role',
                        'a.name as app_name'
                    )
                    ->selectRaw('COALESCE(a.name, "appsmanager") as app_name')
                    ->get()
                    ->toArray();

        foreach ($lRoles as &$subArray) { // se pasa por referencia para modificar el array original
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
        
        return view('rolesVsPermissions.rolePermission')->with('lRoles', $lRoles)->with('lApps', $lApps);
    }

    public function getRolPermissions(Request $request){
        try {
            $lPermissions = RolesVsPermissionsUtils::getRolePermissions($request->id_rol);
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
            $id_rol = $request->id_rol;

            \DB::beginTransaction();

            $oPermission = Permission::where('id_permission', $id_permission)->first();

            $oRolePermission = RolePermission::where('role_id', $id_rol)
                                        ->where('permission_id', $id_permission)
                                        ->first();

            if(!is_null($oRolePermission)){
                if(!$is_active){
                    $oRolePermission->delete();
                }
            }else{
                if($is_active){
                    $oRolePermission = new RolePermission();
                    $oRolePermission->app_n_id = $id_app;
                    $oRolePermission->role_id = $id_rol;
                    $oRolePermission->permission_id = $id_permission;
                    $oRolePermission->save();
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
