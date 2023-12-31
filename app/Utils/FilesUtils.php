<?php namespace App\Utils;

class FilesUtils {

    /**
     * Convierte un tamaño de archivo en su equivalente en bytes.
     * @param string $tamanio Tamaño del archivo con su unidad (ejemplo: 10 MB).
     * @return int|false El tamaño del archivo en bytes, o false en caso de error.
     */
    public static function convertirTamanioBytes($tamanio){
        $unidades = array('B', 'KB', 'MB', 'GB', 'TB');
        $posicion = array_search(substr($tamanio, -2), $unidades);
        if ($posicion === false) {
            return false; // Unidad de tamaño desconocida
        }
        $tamanio = trim(substr($tamanio, 0, -2));
        if (!is_numeric($tamanio)) {
            return false; // El tamaño no es un número
        }
        return $tamanio * pow(1024, $posicion);
    }

    /**
     * Funcion que valida el tipo de archivo recibido y regresa true o false
     * @param mixed $file el archivo a validar
     * @param string $filetype el tipo de archivo a validar, por ejemplo 'pdf', 'xml'...
     * @param int $fileSize el tamaño en bytes del archivo a validar
     */
    public static function validateFile($file, $fileType = null, $fileSize = null){
        $sizeBytes = FilesUtils::convertirTamanioBytes($fileSize);

        $aux1 = $file->isValid();
        $aux2 = $file->getMimeType();

        if(!is_array($fileType)){
            return [false, 'No se reconoce el tipo de archivo para validación'];
        }
        if(count($fileType) < 1){
            return [false, 'No se reconoce el tipo de archivo para validación'];
        }

        if ($file->isValid()) {
            $valid = false;
            foreach ($fileType as $type) {
                // Validamos el tipo de archivo
                if ($file->getMimeType() !== $type) {
                    $valid = false;
                }else{
                    $valid = true;
                    break;
                }
            }

            if(!$valid){
                $delimiter = ", "; // The delimiter to use
                $string = implode($delimiter, $fileType);
                return [false, 'El archivo debe ser '.$string];
            }

            // Validamos el tamaño del archivo en bytes
            $f = $file->getSize();
            if ($file->getSize() > $sizeBytes) {
                return [false, 'El archivo no debe pesar mas de '.$fileSize];
            }
            
            return [true, 'Ok'];
        }
    }
}