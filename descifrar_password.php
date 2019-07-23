<?php
/**
 * Descifrar un archivo con php-encryption; usando una contraseña
 * en lugar de la clave
 *
 * https://parzibyte.me/blog
 *
 */
require_once "vendor/autoload.php";

use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\IOException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\File;

$password = "hunter2";

// Cualquier archivo es válido

// El archivo que se va a descifrar
$rutaArchivoEntrada = __DIR__ . "/script.cifrado.js";
// El archivo de salida; es decir, el que estará descifrado
$rutaArchivoSalida = __DIR__ . "/script.js";

try {
    File::decryptFileWithPassword($rutaArchivoEntrada, $rutaArchivoSalida, $password);
    echo "Archivo $rutaArchivoEntrada descifrado dentro de $rutaArchivoSalida";
    // Opcionalmente podrías eliminar el encriptado:
    # unlink($rutaArchivoEntrada);
    # El manejo de excepciones es opcional ;)
} catch (IOException $e) {
    echo "Error leyendo o escribiendo archivo. Verifica que el archivo de entrada exista y que tengas permiso de escritura";
} catch (EnvironmentIsBrokenException $e) {
    echo "El entorno está roto. Normalmente es porque la plataforma actual no puede encriptar el archivo de una manera segura";
} catch (WrongKeyOrModifiedCiphertextException $e) {
    echo "La clave es errónea o alguien la intentó modificar, cuidado";
}
