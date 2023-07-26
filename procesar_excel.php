<?php
// Incluye la librería PhpSpreadsheet
// asumiendo que subas esto a la raiz de tu carpeta public, si lo subes a una carpeta recuerda agregar ../../vendor/autoload.php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Verifica si se ha subido un archivo
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    // Obtiene la ruta temporal del archivo subido
    $archivoTemporal = $_FILES['archivo']['tmp_name'];

    try {
        // Carga el archivo Excel
        $documento = IOFactory::load($archivoTemporal);
        $hoja = $documento->getActiveSheet();
        $datos = $hoja->toArray(); // Obtiene los datos del archivo Excel como un arreglo

        // Conexión a la base de datos (ajusta los valores según tu configuración)
        $servidor = 'localhost';
        $usuario = 'tu_usuario';
        $contrasena = 'tu_contrasena';
        $basedatos = 'tu_base_de_datos';

        $conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

        // Actualiza los registros en la tabla
        foreach ($datos as $indice => $fila) {
            if ($indice > 0) { // Ignora la primera fila (encabezados)
                $id = $fila[0]; // Suponiendo que la primera columna contiene el ID
                $nombre = $fila[1]; // Suponiendo que la segunda columna contiene el Nombre
                $edad = $fila[2]; // Suponiendo que la tercera columna contiene la Edad

                // Ejecuta la consulta de actualización
                $consulta = "UPDATE tabla_ejemplo SET nombre = '$nombre', edad = '$edad' WHERE id = '$id'";
                $conexion->query($consulta);
            }
        }

        // Cierra la conexión a la base de datos
        $conexion->close();

        echo "Registros actualizados correctamente.";
    } catch (Exception $e) {
        echo "Error al procesar el archivo: " . $e->getMessage();
    }
} else {
    echo "Error al cargar el archivo.";
}
