<?php namespace App\Utils;

class RolesUtils {
    public static function getRolesApp($app_id){
        $lRoles = \DB::table('adm_roles')
                    ->where('app_n_id', $app_id)
                    ->where('is_deleted', 0)
                    ->where('is_super', 0)
                    ->get();

        return $lRoles;
    }

    public static function getAssignedRolesApp($app_id, $user_id){
        $lRoles = \DB::table('adm_roles as r')
                    ->join('adm_user_roles as ur', 'ur.role_id', '=', 'r.id_role')
                    ->where('ur.user_id', $user_id)
                    ->where('ur.app_n_id', $app_id)
                    ->get();

        return $lRoles;
    }
}