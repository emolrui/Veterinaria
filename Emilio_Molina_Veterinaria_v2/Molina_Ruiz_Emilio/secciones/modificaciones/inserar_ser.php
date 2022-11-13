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
                $sacar_id_for="select auto_increment
                                from information_schema.tables
                                where table_schema='veterinaria' and table_name='servicio'";
                $variable=$cone->query($sacar_id_for);
                $ejemploo=$variable->fetch_array(MYSQLI_ASSOC);
            
                echo "<form method='POST' action='#' enctype='multipart/form-data'>
                    <input type='text' name='idd' readonly='readonly' value='$ejemploo[auto_increment]'>
                    <br>
                    <label for='des'>Introduzca la descripcion del servicio</label>
                    <input type='text' name='des'>
                    <br>
                    <label for='dur'>Introduzca la duracion del servicio</label>
                    <input type='number' name='dur'>
                    <br>
                    <label for='edad'>Introduzca el precio</label>
                    <input type='number' name='prec'>
                    <br>
                    <input type='submit' name='insertar'>
                    </form>";
            
                if (isset($_POST['insertar'])) {
                    $descripcion= $_POST['des'];
                    $precio= $_POST['prec'];
                    $duracion= $_POST['dur'];

                    $sacar_id="select auto_increment
                                from iformation_schema.tables
                                where table_schema='veterinaria' and table_name='servicio'";

                    $crear="insert into servicio values(null,?,?,?)";
                    $consulta=$cone->prepare($crear);
                    $consulta->bind_param("sii",$descripcion,$duracion,$precio);
                    $consulta->execute();

                    $consulta->close();
                    echo "<meta http-equiv='refresh' content='0;url=../servicios.php'>";
                    
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