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
                                where table_schema='veterinaria' and table_name='noticia'";
                $variable=$cone->query($sacar_id_for);
                $ejemploo=$variable->fetch_array(MYSQLI_ASSOC);
                
                echo "<form method='POST' action='#' enctype='multipart/form-data'>
                    <input type='text' name='idd' readonly='readonly' value='$ejemploo[auto_increment]'>
                    <br>
                    <label for='tit'>Introduzca el titulo</label>
                    <input type='text' name='tit'>
                    <br>
                    <label for='conteni'>Introduzca el Contenido</label>
                    <input type='text' name='conteni'>
                    <br>
                    <label for='foto'>Introduzca la imagen</label>
                    <input type='file' name='foto'>
                    <br>
                    <label for='fech'>Introduzca la fecha</label>
                    <input type='date' name='fech'>
                    <br>
                    <input type='submit' name='insertar'>
                    </form>";

                    
                if (isset($_POST['insertar'])) {
                    $titulo= $_POST['tit'];
                    $contenido= $_POST['conteni'];
                    $fecha= $_POST['fech'];

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
                                from iformation_schema.tables
                                where table_schema='veterinaria' and table_name='noticia'";
                    $crear="insert into noticia values(null,?,?,?,?)";
                    $consulta=$cone->prepare($crear);
                    $consulta->bind_param("ssss",$titulo,$contenido,$foto,$fecha);
                    $consulta->execute();

                    $consulta->close();
                    echo "<meta http-equiv='refresh' content='0;url=../noticias.php'>";
                    
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