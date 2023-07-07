<?php

namespace App\Http\Controllers\Config;

use App\Constants\SysConst;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserApp;
use App\Models\UserRoles;
use App\Models\UsersTypesusers;
use App\Utils\RolesUtils;
use App\Utils\UsersUtils;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    function getIndexData(){
        $lApps = \DB::table('adm_apps AS a')
                    ->where('a.is_active', true)
                    ->get();

        $lUsers = \DB::table('users AS u')
                    ->where('u.is_active', true)
                    ->where('u.is_deleted', false)
                    ->get();

        foreach ($lUsers as $oUser) {
            foreach ($lApps as $oApp) {
                $oUser->{$oApp->id_app} = \DB::table('adm_user_apps')->where('app_id', $oApp->id_app)
                                                                    ->where('user_id', $oUser->id)
                                                                    ->exists();
            }
        }

        $lTypes = \DB::table('adm_typesuser')
                    ->where('id_typesuser', '!=', 1)
                    ->orderBy('id_typesuser', 'desc')
                    ->get()
                    ->toArray();

        return ['lApps' => $lApps, 'lUsers' => $lUsers, 'lTypes' => $lTypes];
    }

    function userapps () {
        $data = $this->getIndexData();

        $lApps = $data['lApps'];
        $lUsers = $data['lUsers'];
        $lTypes = $data['lTypes'];

        $lConst = [
            'proveedores_app' => SysConst::proveedores_app,
            'redirectsApps' => SysConst::redirectsApps,
        ];

        return view('configurations.userapps')->with('lUsers', $lUsers)
                                            ->with('lApps', $lApps)
                                            ->with('lTypes', $lTypes)
                                            ->with('lConst', $lConst);
    }

    function updateAccess(Request $request) {
        $oUserApp = UserApp::where('user_id', $request->user_id)
                ->where('app_id', $request->app_id)
                ->first();

        if (is_null($oUserApp)) {
            $oUserApp = new UserApp();
            $oUserApp->user_id = $request->user_id;
            $oUserApp->app_id = $request->app_id;
            $oUserApp->save();
        }
        else {
            $oUserApp->delete();
        }

        return json_encode("OK");
    }

    public function createUser(Request $request){
        try {
            $username = $request->username;
            $email = $request->email;
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $names = $request->names;
            $type = $request->type;
            $app_id = $request->app_id;
            $roles_ids = $request->roles_ids;
            $password = UsersUtils::generatePassword();

            \DB::beginTransaction();

            $oUser = new User();
            $oUser->username = $username;
            $oUser->email = $email;
            $oUser->password = $password;
            $oUser->first_name = strtoupper($first_name);
            $oUser->last_name = strtoupper($last_name);
            $oUser->names = strtoupper($names);
            $oUser->full_name = strtoupper($first_name) . ' ' . strtoupper($last_name) . ', '. strtoupper($names);
            $oUser->is_active = 1;
            $oUser->is_deleted = 0;
            $oUser->created_by = \Auth::user()->id;
            $oUser->updated_by = \Auth::user()->id;
            $oUser->save();

            $oUserApp = new UserApp();
            $oUserApp->user_id = $oUser->id;
            $oUserApp->app_id = $app_id;
            $oUserApp->save();

            foreach ($roles_ids as $rol) {
                $oRole = new UserRoles();
                $oRole->app_n_id = $app_id;
                $oRole->user_id = $oUser->id;
                $oRole->role_id = $rol;
                $oRole->save();
            }

            $oType = new UsersTypesusers();
            $oType->user_id = $oUser->id;
            $oType->app_id = $app_id;
            $oType->typeuser_id = $type;
            $oType->save();

            $data = $this->getIndexData();

            $lUsers = $data['lUsers'];

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
            return json_encode(['success' => false, 'message' => $th->getMessage(), 'icon' => 'error']);
        }

        return json_encode(['success' => true, 'lUsers' => $lUsers]);
    }

    public function getRolesApp(Request $request){
        try {
            $lRoles = RolesUtils::getRolesApp($request->app_id);
            
            $arrRol  = [];
            foreach($lRoles as $rol){
                array_push($arrRol, ['id' => $rol->id_role, 'text' => $rol->role]);
            }

        } catch (\Throwable $th) {
            return json_encode(['success' => false, 'message' => $th->getMessage()]);
        }

        return json_encode(['success' => true, 'lRoles' => $arrRol]);
    }
}
