<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Dueños</title>
</head>
<body>
    <header>
        
        <?php
                require_once("../funciones/funciones.php");
                $cone =conectar();
    
                echo crear_menu();
            ?>
    </header>

    <main>
        <?php

        if (isset($_COOKIE['Sesion_ejem'])) {
            
            if (!isset($_SESSION['nombre'])) {
                echo "<div class='sesion_inv'>Sesión inválida</div>";
            }elseif ($_SESSION['nombre']=='admin') {
                echo "<p><a href='modificaciones/inserar_due.php'><button type='submit' name='insertar'>
                                                                            Insertar
                                                                        </button>
                       </a>
                   </p>";
                echo "<form action='#' method='post'>
                        <label for='filtro'>Filtro:</label>
                        <input type='text' name='filtro'>
                        <input type='submit' name='buscar' value='buscar'>
                    </form>";

                

                if (isset($_POST['buscar'])) {
                    $filtro=$_POST['filtro'];
                    $mostrar1=" select *
                                from  dueño
                                where nombre=? or nick=? or telefono=?";
                    $consulta=$cone->prepare($mostrar1);
                    $consulta->bind_param("sss",$filtro,$filtro,$filtro);
                    $consulta->bind_result($dni,$nombre,$telefono,$nick,$pass);
                    $consulta->execute();

                    while ($consulta->fetch()) {
                        echo "
                            <div class='forma_cli'>
                                <p><h2>Nombre:</h2>$nombre</p>
                                <p><h2>Telefono:</h2>$telefono</p>
                                <p><h2>Nick:</h2>$nick </p>
                                <p><h2>DNI:</h2>$dni </p>

                                
                                <form action='modificaciones/modificar_due.php' method='post'>
                                    <input type='hidden' name='id_modi' value=$dni>
        
                                    <input type='submit' name='modific' value='Modificar'>
                                </form>
                            </div>
                            <br>
                            ";
        
                    }
                    $consulta->close();
                    
                }else{
                    $mostrar1="select * from dueño";

                    $resultado= $cone->query($mostrar1);

                    while ($due= $resultado->fetch_array(MYSQLI_ASSOC)) {
                        echo "
                            <div class='forma_cli'>
                                <p><h2>Nombre:</h2>$due[nombre]</p>
                                <p><h2>Telefono:</h2>$due[telefono]</p>
                                <p><h2>Nick:</h2>$due[nick]</p>
                                <p><h2>DNI:</h2>$due[dni]</p>
                                <form action='modificaciones/modificar_due.php' method='post'>
                                    <input type='hidden' name='id_modi' value=$due[dni]>
        
                                    <input type='submit' name='modific' value='Modificar'>
                                </form>
        
                                    
                                
                                
                            </div>
                            <br>
                            ";
        
                    }
                }
            }elseif($_SESSION['nombre']!='admin') {
                $usuario=$_SESSION['nombre'];
                $mostrar1="select * from dueño where dueño.nick='$usuario'";

                    $resultado= $cone->query($mostrar1);

                    while ($due= $resultado->fetch_array(MYSQLI_ASSOC)) {
                        echo "
                            <div class='forma_cli'>
                                <p><h2>Nombre:</h2>$due[nombre]</p>
                                <p><h2>Telefono:</h2>$due[telefono]</p>
                                <p><h2>Nick:</h2>$due[nick]</p>
                                <p><h2>DNI:</h2>$due[dni]</p>
                                <form action='modificaciones/modificar_due.php' method='post'>
                                    <input type='hidden' name='id_modi' value=$due[dni]>
        
                                    <input type='submit' name='modific' value='Modificar'>
                                </form>
        
                                    
                                
                                
                            </div>
                            <br>
                            ";
        
                    }
            }
        
            

        }else {
            echo "<div class='sesion_inv'>Sesión inválida</div>";
        }
            
        ?>
    </main>

    <footer>
        <?php
            echo crear_pie();
            $cone->close();
        ?>

    </footer>
    
</body>
</html>