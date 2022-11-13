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
                                where table_schema='veterinaria' and table_name='cliente'";
                $variable=$cone->query($sacar_id_for);
                $ejemploo=$variable->fetch_array(MYSQLI_ASSOC);
            
                echo"<form method='POST' action='#' enctype='multipart/form-data'>
                    <input type='text' name='idd' readonly='readonly' value='$ejemploo[auto_increment]'>
                    <br>
                    <label for='tip'>Introduzca el tipo</label>
                    <input type='text' name='tip'>
                    <br>
                    <label for='nombr'>Introduzca el nombre de su mascota</label>
                    <input type='text' name='nombr'>
                    <br>
                    <label for='edad'>Introduzca la edad de su mascota</label>
                    <input type='number' name='edad'>
                    <br>
                    <label for='dni_dueño'>Introduzca el dni del dueño</label>
                    <input type='text' name='dni_dueño'>
                    <br>
                    Imagen
                    <input type='file' name='foto'>
                    <br>
                    <input type='submit' name='insertar'>
                    </form>";

                if (isset($_POST['insertar'])) {
                    $tipo= $_POST['tip'];
                    $nombre_mas= $_POST['nombr'];
                    $edad= $_POST['edad'];
                    $nombre_dueño= $_POST['dni_dueño'];
                    // $para1='foto';
                    // imagen($para1);
                    if ($_FILES['foto']['size']>0) {
                        $foto= $_FILES['foto']['name'];
                        $temp=$_FILES['foto']['tmp_name'];
                        if (!file_exists("../../img")) {
                            mkdir("../../img");
                        }
                        if ($_FILES["foto"]["type"]==="image/jpeg") {
                            $foto=$foto.".jpeg";
                        }elseif ($_FILES["foto"]["type"]==="image/png") {
                            $foto=$foto.".png";
                        }elseif ($_FILES["foto"]["type"]==="image/jpg") {
                            $foto=$foto.".jpg";
                        }elseif ($_FILES["foto"]["type"]==="image/gif") {
                            $foto=$foto.".gif";
                        }
                        $ruta="../../img/$foto";
                        $ruta2="../img/$foto";
                        move_uploaded_file ($temp,$ruta);
                    }

                    

                    $sacar_id="select auto_increment
                                from information_schema.tables
                                where table_schema='veterinaria' and table_name='cliente'";
                    $crear="insert into cliente values(null,?,?,?,?,?)";
                    $consulta=$cone->prepare($crear);
                    $consulta->bind_param("ssiss",$tipo,$nombre_mas,$edad,$nombre_dueño,$ruta2);
                    $consulta->execute();

                    $consulta->close();
                    echo "<meta http-equiv='refresh' content='0;url=../clientes.php'>";
                    
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