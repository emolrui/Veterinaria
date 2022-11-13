
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
    <title>Insertar dueño</title>
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
                
            
                echo "<form method='POST' action='#' enctype='multipart/form-data'>
                    <label for='dni'>DNI:</label>
                    <input type='text' name='dni'>
                    <br>
                    <label for='nombre'>Nombre:</label>
                    <input type='text' name='nombre'>
                    <br>
                    <label for='telefono'>Telefono:</label>
                    <input type='text' name='telefono'>
                    <br>
                    <label for='nick'>Nick:</label>
                    <input type='text' name='nick'>
                    <br>
                    <label for='pass'>Contraseña:</label>
                    <input type='password' name='pass' id='contrasenia'>
                    <br>
                    <input type='submit' name='insertar'>
                    </form>";
            
                if (isset($_POST['insertar'])) {
                    $dni= $_POST['dni'];
                    $nombre= $_POST['nombre'];
                    $telefono= $_POST['telefono'];
                    $nick= $_POST['nick'];
                    $pass= $_POST['pass'];



                    $crear="insert into dueño values(?,?,?,?,?)";
                    $consulta=$cone->prepare($crear);
                    $consulta->bind_param("sssss",$dni,$nombre,$telefono,$nick,$pass);
                    $consulta->execute();

                    $consulta->close();
                    echo "<meta http-equiv='refresh' content='0;url=../dueños.php'>";
                    
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