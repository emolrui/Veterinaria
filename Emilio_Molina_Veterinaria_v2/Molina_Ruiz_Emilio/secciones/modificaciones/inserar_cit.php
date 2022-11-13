<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Insertar</title>
</head>
<body>
    <header>
        <?php
            require_once("../../funciones/funciones.php");
            $cone =conectar();
            $para1="../../";
            $para2="../";
            echo crear_menu($para1,$para2);
        ?>
    </header>
    <main>
        <?php

        if (isset($_COOKIE['Sesion_ejem'])) {
           
        
            if ($_SESSION['nombre']=='admin') {
                
            
                echo"<form method='POST' action='#' enctype='multipart/form-data'>";
                
                $clientes_id="select nombre, id from cliente ";
                $contenido_id=$cone->query($clientes_id);
                echo"Cliente:  <select name='Clientes'>";
                while ($id_desplegable=$contenido_id->fetch_array(MYSQLI_ASSOC)) {
                echo" <option value=$id_desplegable[id]>$id_desplegable[nombre]</option>";
                }
                echo "</select><br>";

                $servicio_id="select descripcion, id from servicio ";
                $contenido_id_ser=$cone->query($servicio_id);


                echo" Servicio: <select name='Servicios'>";
                while ($id_desplegable_ser=$contenido_id_ser->fetch_array(MYSQLI_ASSOC)) {
                echo" <option value=$id_desplegable_ser[id]>$id_desplegable_ser[descripcion]</option>";
                }
                echo "</select><br>";


                echo"<label for='fecha'>Fecha:</label>
                    <input type='date' name='fecha'>
                    <br>
                    <label for='hora'>Hora:</label>
                    <input type='time' name='hora'>
                    <br>
                    <input type='submit' name='insertar'>
                    </form>";

                if (isset($_POST['insertar'])) {
                    $nom_cli= $_POST['Clientes'];
                    $servicio= $_POST['Servicios'];
                    $fecha= $_POST['fecha'];
                    $hora= $_POST['hora'];

                    $crear="insert into citas values(?,?,?,?)";
                    $consulta=$cone->prepare($crear);
                    $consulta->bind_param("iiss",$nom_cli,$servicio,$fecha,$hora);
                    $consulta->execute();

                    $consulta->close();
                    echo "<meta http-equiv='refresh' content='0;url=../citas.php'>";
                    
                }
            
            }else {
                echo "<div class='sesion_inv'>Sesión inválida</div>";
            }

        }else {
            echo "<div class='sesion_inv'>Sesión inválida</div>";
        }


        ?>
    </main>
    <footer>
        <?php 
            $para1="../../";
            $para2="../";
            echo crear_pie($para1,$para2);
            $cone->close();
        ?>
    </footer>

</body>
</html>