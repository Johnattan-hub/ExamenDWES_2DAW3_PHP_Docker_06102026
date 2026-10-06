<html>
    <head>
        <title>Examen de Desarrollo web en entorno servidor</title>
        <link rel="icon" type="image/png" sizes="32x32" href="../imagenes/favicon.jpeg">
        <link rel="stylesheet" type="text/css" href="../estilos/estilos.css">

    </head>
    <body>
        <h1>Centro de Ayuda al Empleo</h1>
        <h2>    
            <?php
                $tipo = "Soldadura";
                if ($_REQUEST['tipo'] == 'informatica'){
                    $tipo = 'Informática';
                } elseif ($_REQUEST['tipo'] == 'socio'){
                    $tipo = "Asistencia Sociosanitaria";
                }
                echo "Solicitudes de $tipo";
            ?>
        </h2>

        
        <?php
            include "conexion.php"; // Conexión a la base de datos "cae"

            // Pasamos el tipo (texto) al número que guardamos en la BD
            if ($_REQUEST['tipo'] == 'informatica') {
                $profesion = 2;
            } elseif ($_REQUEST['tipo'] == 'socio') {
                $profesion = 3;
            } else {
                $profesion = 1; 
            }

            
            if (isset($_POST['nombre'])) {
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $dni = $_POST['dni'];
                $f_nac = $_POST['f_nac'];
                $tlf = $_POST['tlf'];
                $email = $_POST['email'];
                $jornadaParcial = $_POST['jornada'];


                $idiomas = 0;
                if (isset($_POST['euskera'])) {
                    $idiomas = $idiomas + 1;
                }
                if (isset($_POST['ingles'])) {
                    $idiomas = $idiomas + 2;
                }

                $sql = "INSERT INTO solicitud
                (nombre, apellidos, dni, f_nac, tlf, email, profesion, jornadaParcial, idiomas)
                VALUES
                ('$nombre', '$apellidos', '$dni', '$f_nac', '$tlf', '$email', '$profesion', '$jornadaParcial', '$idiomas')";

                mysqli_query($conexion, $sql);
            }

            $sql = "SELECT * FROM solicitud WHERE profesion = $profesion";
            $resultado = mysqli_query($conexion, $sql);

            echo "<table>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Apellidos</th><th>DNI</th><th>Fecha nac.</th><th>Teléfono</th><th>Email</th><th>Jornada</th><th>Idiomas</th></tr>";

            while ($fila = mysqli_fetch_assoc($resultado)) {

                if ($fila['jornadaParcial'] == 1) {
                    $jornada = "Parcial";
                } else {
                    $jornada = "Completa";
                }

                if ($fila['idiomas'] == 1) {
                    $idiomas = "Euskera";
                } elseif ($fila['idiomas'] == 2) {
                    $idiomas = "Inglés";
                } elseif ($fila['idiomas'] == 3) {
                    $idiomas = "Euskera e Inglés";
                } else {
                    $idiomas = "Ninguno";
                }

                echo "<tr>";
                echo "<td>" . $fila['id'] . "</td>";
                echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['apellidos']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['dni']) . "</td>";
                echo "<td>" . $fila['f_nac'] . "</td>";
                echo "<td>" . $fila['tlf'] . "</td>";
                echo "<td>" . htmlspecialchars($fila['email']) . "</td>";
                echo "<td>$jornada</td>";
                echo "<td>$idiomas</td>";
                echo "</tr>";
            }

            echo "</table>";

            mysqli_close($conexion);
        ?>
        
        <button onclick="location.href='../html/index.html'">Volver al formulario</button>
    </body>
</html>