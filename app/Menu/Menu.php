<?php

namespace App\Menu;

class Menu
{
    public static function createMenu($oUser = null)
    {
        $element = 1;
        $list = 2;
        if (is_null($oUser)) {
            return "";
        }

        $roles = $oUser->roles()->pluck('id_role')->toArray();
        
        $lMenus = [];

        if (in_array(1, $roles)) {
            $lMenus = [
                (object) ['type' => $element, 'route' => route('home'), 'icon' => 'bx bx-home bx-sm', 'name' => 'Inicio'],
                (object) [
                    'type' => $list,
                    'list' => [
                        ['route' => route('rolesvspermissions_index'), 'icon' => 'bx bxs-file bx-sm', 'name' => 'Roles permisos'],
                        ['route' => route('usersVsPermissions_index'), 'icon' => 'bx bxs-user-badge bx-sm', 'name' => 'Usuarios permisos'],
                    ],
                    'icon' => 'bx bx-no-entry bx-sm',
                    'name' => 'Permisos',
                    'id' => 'permisos'
                ],
                (object) ['type' => $element, 'route' => route('config.userapps'), 'icon' => 'bx bxs-user bx-sm', 'name' => 'Usuarios'],
            ];
        }

        if (in_array(2, $roles)) {
            $lMenus = [
                (object) ['type' => $element, 'route' => route('home'), 'icon' => 'bx bx-home bx-sm', 'name' => 'Inicio'],
            ];
        }

        if (in_array(3, $roles)) {
            $lMenus = [
                (object) ['type' => $element, 'route' => route('home'), 'icon' => 'bx bx-home bx-sm', 'name' => 'Inicio'],
            ];
        }

        $sMenu = "";
        foreach ($lMenus as $menu) {
            if ($menu == null) {
                continue;
            }
            if ($menu->type == $element) {
                $sMenu = $sMenu . Menu::createMenuElement($menu->route, $menu->icon, $menu->name);
            } else if ($menu->type == $list) {
                $sMenu = $sMenu . Menu::createListMenu($menu->id, $menu->list, $menu->name, $menu->icon);
            }
        }

        return $sMenu;
    }

    private static function createMenuElement($route, $icon, $name)
    {
        return '<li class="nav-item">
                    <a class="nav-link" href="' . $route . '">
                        <i class="' . $icon . ' menu-icon"></i>
                        <span class="menu-title">' . $name . '</span>
                    </a>
                </li>';
    }

    private static function createListMenu($id, $list, $name, $icon)
    {
        $str = '<li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#' . $id . '" aria-expanded="false" aria-controls="' . $id . '">
                        <i class="' . $icon . ' menu-icon"></i>
                            <span class="menu-title">' . $name . '</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="' . $id . '">
                        <ul class="nav flex-column sub-menu">';

        foreach ($list as $l) {
            if (!isset($l['size'])) {
                $str = $str . '<li class="nav-item"> <a class="nav-link" href="' . $l['route'] . '">' . $l['name'] . '</a></li>';
            } else {
                $str = $str . '<li class="nav-item"> <a class="nav-link" href="' . $l['route'] . '" style="font-size:' . $l['size'] . '">' . $l['name'] . '</a></li>';
            }
        }

        $str = $str . '</ul></div></li>';

        return $str;
    }
}