<?php
/**
 * Descifrar un archivo con php-encryption
 *
 * https://parzibyte.me/blog
 *
 */
require_once "vendor/autoload.php";

use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\IOException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\File;
use Defuse\Crypto\Key;

// Cualquier archivo es válido

// El archivo que se va a descifrar
$rutaArchivoEntrada = __DIR__ . "/kotlin.cifrado.png";
// El archivo de salida; es decir, el que estará descifrado
$rutaArchivoSalida = __DIR__ . "/kotlin.png";
// No olvides guardar la clave en un lugar seguro; aquí lo pongo así de simple para ejemplos de
// simplicidad
$contenido = file_get_contents("clave.txt");
// Cargar la clave desde una cadena ASCII (pues la clave no es tan legible ni entendible como una simple cadena)
$clave = Key::loadFromAsciiSafeString($contenido);
// Y ya podemos descifrar el archivo
try {
    File::decryptFile($rutaArchivoEntrada, $rutaArchivoSalida, $clave);
    echo "Archivo $rutaArchivoEntrada descifrado dentro de $rutaArchivoSalida";
    // Opcionalmente podrías eliminar el cifrado:
    # unlink($rutaArchivoEntrada);
    # El manejo de excepciones es opcional ;)
} catch (IOException $e) {
    echo "Error leyendo o escribiendo archivo. Verifica que el archivo de entrada exista y que tengas permiso de escritura";
} catch (EnvironmentIsBrokenException $e) {
    echo "El entorno está roto. Normalmente es porque la plataforma actual no puede encriptar el archivo de una manera segura";
} catch (WrongKeyOrModifiedCiphertextException $e) {
    echo "La clave es errónea o alguien la intentó modificar, cuidado";
}
