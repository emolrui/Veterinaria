<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Modificar dueño</title>
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
                $idm=$_POST['id_modi'];
                $consulta="select * from dueño where dni=$idm";
                $resultado=$cone->query($consulta);
                $fila=$resultado->fetch_array(MYSQLI_ASSOC);
                 if ($_SESSION['nombre']=='admin') {
                    
                    echo"<form method='POST' action='#' enctype='multipart/form-data'>
                            <label for='dni'>DNI:</label>
                            <input type='text' name='dni'  value='$fila[dni]'>
                            <input type='hidden' name='id_modi' value='$fila[dni]'>
                            <br>  
                            <label for='nombr'>Nombre del dueño:</label>
                            <input type='text' name='nombr' value='$fila[nombre]'>
                            <br>
                            <label for='telefono'>Telefono:</label>
                            <input type='text' name='telefono' value='$fila[telefono]'>
                            <br> 
                            <label for='nick'>Nick:</label>
                            <input type='text' name='nick' value='$fila[nick]'>
                            <input type='hidden' name='contraseña' value='$fila[pass]'>
                            <br>     
                            <input type='submit' name='modificar'>

                    </form>";


                    if (isset($_POST['modificar'])) {
                        $dni= $_POST['dni'];
                        $nombre= $_POST['nombr'];
                        $telefono= $_POST['telefono'];
                        $nick= $_POST['nick'];
                        $contraseña= $_POST['contraseña'];
                        
                        $actualiza="update dueño
                                set dni=?, nombre=? , telefono=? , nick=?, pass=?
                                where dni=$dni"; 

                        $consulta=$cone->prepare($actualiza);
                        $consulta->bind_param("sssss",$nombre,$telefono,$nick,$contraseña);
                        $consulta->execute();

                        $consulta->close();
                        echo "<meta http-equiv='refresh' content='0;url=../dueños.php'>";
                    }
                 }else {
                     
                    echo"<form method='POST' action='#' enctype='multipart/form-data'>
                            <label for='dni'>DNI:</label>
                            <input type='text' name='dni' readonly='readonly' value='$fila[dni]'>
                            <input type='hidden' name='id_modi' value='$fila[dni]'>
                            <br>  
                            <label for='nombr'>Nombre del dueño:</label>
                            <input type='text' name='nombr' readonly='readonly' value='$fila[nombre]'>
                            <br>
                            <label for='telefono'>Telefono:</label>
                            <input type='text' name='telefono' value='$fila[telefono]'>
                            <br>
                            <label for='contraseña'>Contraseña:</label>
                            <input type='password' name='contraseña' value='$fila[pass]'>
                            <br> 
                            <label for='nick'>Nick:</label>
                            <input type='text' name='nick' readonly='readonly' value='$fila[nick]'>
                            <br>     
                            <input type='submit' name='modificar'>

                    </form>";


                    if (isset($_POST['modificar'])) {
                        $id2= $_POST['dni'];
                        $telefono= $_POST['telefono'];
                        $contraseña= $_POST['contraseña'];
                        
                        $actualiza="update dueño
                                set telefono=? , pass=?
                                where dni=$id2"; 

                        $consulta=$cone->prepare($actualiza);
                        $consulta->bind_param("ss",$telefono,$contraseña);
                        $consulta->execute();

                        $consulta->close();
                        echo "<meta http-equiv='refresh' content='0;url=../dueños.php'>";
                    }
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