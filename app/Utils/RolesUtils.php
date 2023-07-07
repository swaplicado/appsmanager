<?php namespace App\Utils;

class RolesUtils {
    public static function getRolesApp($app_id){
        $lRoles = \DB::table('adm_roles')
                    ->where('app_n_id', '!=', null)
                    ->where('is_deleted', 0)
                    ->where('is_super', 0)
                    ->get();

        return $lRoles;
    }    
}