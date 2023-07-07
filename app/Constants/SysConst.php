<?php namespace App\Constants;

class SysConst {
    
    /**
     * Constantes de la tabla adm_apps
     */
    public const proveedores_app = 1;
    
    /**
     * Constantes de la table adm_roles para la app proveedores
     */
    public const proveedores_roles = [
        'PROVEEDOR' => 2
    ];

     /**
      * Constantes para saber que apps tienen redireccion
      */
    public const redirectsApps = [
        self::proveedores_app => [ 
                                    ['route' => 'http://127.0.0.1:8001/providers', 'text' => 'Es proveedor'],
                                    ['route' => 'http://127.0.0.1:8001/compras', 'text' => 'Es compras'],
                                    ['route' => 'http://127.0.0.1:8001/compras', 'text' => 'Es otro'],
                                ],
    ];
}