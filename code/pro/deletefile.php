<?php
// Verificar si se recibió el nombre del archivo a eliminar
if(isset($_POST['file_path'])) {
    $file_path = $_POST['file_path'];

    // Verificar si el archivo existe antes de intentar eliminarlo
    if(file_exists($file_path)) {
        // Intentar eliminar el archivo
        if(unlink($file_path)) {
            // Devolver una respuesta de éxito si se eliminó correctamente
            echo "success";
        } else {
            // Devolver un mensaje de error si no se pudo eliminar el archivo
            echo "error";
        }
    } else {
        // Devolver un mensaje de error si el archivo no existe
        echo "error";
    }
} else {
    // Devolver un mensaje de error si no se proporcionó el nombre del archivo
    echo "error";
}
?>
