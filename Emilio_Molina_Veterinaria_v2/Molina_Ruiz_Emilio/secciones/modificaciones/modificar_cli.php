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
                
                
                 $idm=$_POST['id_modi'];
                 $consulta="select * from cliente where id=$idm";
                 $resultado=$cone->query($consulta);
                 $fila=$resultado->fetch_array(MYSQLI_ASSOC);
                 echo"<form method='POST' action='#' enctype='multipart/form-data'>
                        <label for='id'>Id:</label>
                        <input type='text' name='id' readonly='readonly' value='$fila[id]'>
                        <input type='hidden' name='id_modi' value=$fila[id]>
                        <br>  
                        <label for='tip'>Tipo:</label>
                        <input type='text' name='tip' value='$fila[tipo]'>
                        <br>
                        <label for='nombr'>Nombre de su mascota:</label>
                        <input type='text' name='nombr' value='$fila[nombre]'>
                        <br>
                        <label for='edad'>Edad de su mascota:</label>
                        <input type='number' name='edad' value='$fila[edad]'>
                        <br>
                        <label for='dni_dueño'>Nombre:</label>
                        <input type='text' name='dni_dueño' value='$fila[dni_dueño]'>
                        <br>
                            Imagen
                        <input type='file' name='foto' value='$fila[foto]'>
                        <br>
                        
                        <input type='submit' name='modificar'>

                 </form>";


                if (isset($_POST['modificar'])) {
                    $id2= $_POST['id'];
                    $tipo= $_POST['tip'];
                    $nombre_mas= $_POST['nombr'];
                    $edad= $_POST['edad'];
                    $dni_dueño= $_POST['dni_dueño'];

                    if ($_FILES['foto']['size']>0) {
                        $foto= $_FILES['foto']['name'];
                        $temp=$_FILES['foto']['tmp_name'];
                        if (!file_exists("../../img")) {
                            mkdir("../../img");
                        }
                        // if ($_FILES["foto"]["type"]==="image/jpeg") {
                        //     $foto=$foto.".jpeg";
                        // }elseif ($_FILES["foto"]["type"]==="image/png") {
                        //     $foto=$foto.".png";
                        // }elseif ($_FILES["foto"]["type"]==="image/jpg") {
                        //     $foto=$foto.".jpg";
                        // }elseif ($_FILES["foto"]["type"]==="image/gif") {
                        //     $foto=$foto.".gif";
                        // }
                        $ruta="../../img/$foto";
                        $ruta2="$foto";
                        move_uploaded_file ($temp,$ruta);

                        $actualiza="update cliente
                            set tipo=? , nombre=? , edad=? , dni_dueño=?  , foto=?
                            where id=$idm";
                            $consulta=$cone->prepare($actualiza);
                    $consulta->bind_param("ssiss",$tipo,$nombre_mas,$edad,$dni_dueño,$ruta2);
                    }else{
                        $actualiza="update cliente
                            set tipo=? , nombre=? , edad=? , dni_dueño=?  where id=$idm";
                            $consulta=$cone->prepare($actualiza);
                    $consulta->bind_param("ssis",$tipo,$nombre_mas,$edad,$dni_dueño);
                    }
                    

                    
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