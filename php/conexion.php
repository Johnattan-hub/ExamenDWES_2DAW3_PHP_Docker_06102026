<?php

$conexion = mysqli_connect("localhost", "root", "", "cae");

if (!$conexion) {
    echo "Error en la conexión con la base de datos";
}

?>