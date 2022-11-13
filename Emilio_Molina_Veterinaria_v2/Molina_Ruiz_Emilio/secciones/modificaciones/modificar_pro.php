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
                 $consulta="select * from producto where id=$idm";
                 $resultado=$cone->query($consulta);
                 $fila=$resultado->fetch_array(MYSQLI_ASSOC);
                 echo"<form method='POST' action='#' enctype='multipart/form-data'>
                        <label for='id'>Id:</label>
                        <input type='text' name='id' readonly='readonly' value='$fila[id]'>
                        <input type='hidden' name='id_modi' value='$fila[id]'>
                        <br>  
                        <label for='nombr'>Nombre del producto:</label>
                        <input type='text' name='nombr' value='$fila[nombre]'>
                        <br>
                        <label for='precio'>Precio del producto:</label>
                        <input type='number' name='precio' value='$fila[precio]'>
                        <br>     
                        <input type='submit' name='modificar'>

                 </form>";


                if (isset($_POST['modificar'])) {
                    $id2= $_POST['id'];
                    $nombre= $_POST['nombr'];
                    $precio= $_POST['precio'];
                    
                    $actualiza="update producto
                            set nombre=? , precio=? 
                            where id=$id2"; 

                    $consulta=$cone->prepare($actualiza);
                    $consulta->bind_param("si",$nombre,$precio);
                    $consulta->execute();

                    $consulta->close();
                    echo "<meta http-equiv='refresh' content='0;url=../productos.php'>";
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