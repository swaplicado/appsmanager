<?php namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class PermissionsUtils {
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

    public static function getUserPermission($user_id){
        // $keys = \DB::table('adm_permission_keys as k')
        //             ->join('adm_user_apps as ua', 'ua.app_id', '=', 'k.app_n_id')
        //             ->where('ua.user_id', $user_id)
        //             ->select(
        //                 'k.*'
        //             )
        //             ->get();

        $RolePermissions = \DB::table('adm_user_roles as ur')
                                ->join('adm_roles_permissions as rp', 'rp.role_id', '=', 'ur.role_id')
                                ->join('adm_permissions as p', 'p.id_permission', '=', 'rp.permission_id')
                                ->join('adm_roles as r', 'r.id_role', '=', 'ur.role_id')
                                ->where('ur.user_id', $user_id)
                                ->select(
                                    'p.id_permission',
                                    'ur.role_id',
                                    'p.key_code',
                                    'p.level',
                                    'r.role'
                                )
                                ->selectRaw('true as checked')
                                ->get();

        $assignedPermissions = \DB::table('adm_user_permissions as up')
                                ->join('adm_permissions as p', 'p.id_permission', '=', 'up.permission_id')
                                ->where('up.user_id', $user_id)
                                ->where('is_blocked', 0)
                                ->selectRaw('p.id_permission, 0 as role_id, p.key_code, p.level, "" as role, true as checked')
                                ->get();

        $blockedPermissions = \DB::table('adm_user_permissions as up')
                                ->join('adm_permissions as p', 'p.id_permission', '=', 'up.permission_id')
                                ->where('up.user_id', $user_id)
                                ->where('is_blocked', 1)
                                ->pluck('p.id_permission')
                                ->toArray();

        
        $RolePermissions->map( function($item) use($blockedPermissions){
            $item->checked = in_array($item->id_permission, $blockedPermissions) ? false : true;
            return $item;
        });

        $lPermissions = $assignedPermissions->merge($RolePermissions);

        $unassignedPermissions = \DB::table('adm_permissions')
                                    ->whereNotIn('id_permission', $lPermissions->pluck('id_permission'))
                                    ->selectRaw('id_permission, 0 as role_id, key_code, level, "" as role, false as checked')
                                    ->get();

        $unassignedPermissions->map( function($item){
            $item->checked = $item->checked == 0 ? false : $item->checked;
            return $item;
        });

        $lPermissions = $lPermissions->merge($unassignedPermissions);
        
        return $lPermissions;
    }
}