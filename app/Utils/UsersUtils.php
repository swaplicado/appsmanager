<?php namespace App\Utils;

class UsersUtils {
    public static function generatePassword($longitud = 8){
        $caracteres = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
        $longitudCaracteres = strlen($caracteres);
        $contrasena = '';
        for ($i = 0; $i < $longitud; $i++) {
            $indiceAleatorio = mt_rand(0, $longitudCaracteres - 1);
            $contrasena .= $caracteres[$indiceAleatorio];
        }

        return $contrasena;
    }
}