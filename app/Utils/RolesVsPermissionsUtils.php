<?php namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class RolesVsPermissionsUtils {
    public static function getRolePermissions($role_id){
        $keys = \DB::table('adm_permission_keys as k')
                    ->join('adm_roles as r', 'r.app_n_id', '=', 'k.app_n_id')
                    ->where('r.id_role', $role_id)
                    ->select(
                        'k.*'
                    )
                    ->get();

        $assignPermissions = \DB::table('adm_roles_permissions as rp')
                                ->leftJoin('adm_permissions as p', 'p.id_permission', '=', 'rp.permission_id')
                                ->where('rp.role_id', $role_id)
                                ->select(
                                    'p.id_permission',
                                    'p.key_code',
                                    'p.level'
                                )
                                ->selectRaw('true as checked')
                                ->get();

        $permissionIds = $assignPermissions->pluck('id_permission')->toArray();

        $unsignedPermissions = \DB::table('adm_permissions as p')
                                    ->whereNotIn('id_permission', $permissionIds)
                                    ->select(
                                        'p.id_permission',
                                        'p.key_code',
                                        'p.level'
                                    )
                                    ->selectRaw('false as checked')
                                    ->get();

        $lPermissions = $assignPermissions->merge($unsignedPermissions);

        foreach ($keys as $k) {
            $k->permissions = $lPermissions->where('key_code', $k->key_code);
        }

        return $keys;
    }
}