<?php
require 'connect.php';

if ($pdo) {
    echo "Conexión exitosa";
} else {
    echo "Error en la conexión";
}
?>
