<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Clientes</title>
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
                echo "<p><a href='modificaciones/inserar_cli.php'><button type='submit' name='insertar'>
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
                    $mostrar1=" select cliente.id, cliente.tipo, cliente.nombre, cliente.edad, cliente.dni_dueño, cliente.foto
                                from cliente, dueño
                                where cliente.dni_dueño = dueño.dni and
                                cliente.nombre=? or dueño.nombre=?";
                    $consulta=$cone->prepare($mostrar1);
                    $consulta->bind_param("ss",$filtro,$filtro);
                    $consulta->bind_result($id,$tipo,$nombre,$edad,$dni_dueño,$foto);
                    $consulta->execute();

                    while ($consulta->fetch()) {
                        echo "
                            <div class='forma_cli'>
                                <p><h2>Nombre:</h2>$nombre</p>
                                <p><h2>Tipo:</h2>$tipo</p>
                                <p><h2>Edad:</h2>$edad años</p>
                                <p><h2>Dni dueño:</h2>$dni_dueño</p>
                                
                                <div>
                                    <img src='../img/$foto'>
                                </div>
                                <form action='modificaciones/modificar_cli.php' method='post'>
                                    <input type='hidden' name='id_modi' value=$id>
        
                                    <input type='submit' name='modific' value='Modificar'>
                                </form>
                            </div>
                            <br>
                            ";
        
                    }
                    $consulta->close();
                    
                }else{
                    $mostrar1="select cliente.id, cliente.tipo, cliente.nombre, cliente.edad, dueño.nombre nmb, cliente.foto 
                    from cliente,dueño
                    where cliente.dni_dueño = dueño.dni";

                    $resultado= $cone->query($mostrar1);
                    while ($client= $resultado->fetch_array(MYSQLI_ASSOC)) {
                        echo "
                            <div class='forma_cli'>
                                <p><h2>Nombre:</h2>$client[nombre]</p>
                                <p><h2>Tipo:</h2>$client[tipo]</p>
                                <p><h2>Nombre del dueño:</h2>$client[nmb]</p>
                                
                                <div>
                                    <img src='../img/$client[foto]'>
                                </div>
                                <form action='modificaciones/modificar_cli.php' method='post'>
                                    <input type='hidden' name='id_modi' value=$client[id]>
        
                                    <input type='submit' name='modific' value='Modificar'>
                                </form>
        
                                    
                                
                                
                            </div>
                            <br>
                            ";
        
                    }
                }
            }elseif($_SESSION['nombre']!="admin") {
                $usuario=$_SESSION['nombre'];

                $mostrar1="select cliente.id, cliente.tipo, cliente.nombre, cliente.edad, cliente.foto 
                    from cliente,dueño
                    where cliente.dni_dueño = dueño.dni and dueño.nick='$usuario'";

                    $resultado= $cone->query($mostrar1);
                    while ($client= $resultado->fetch_array(MYSQLI_ASSOC)) {
                        echo "
                            <div class='forma_cli'>
                                <p><h2>Nombre:</h2>$client[nombre]</p>
                                <p><h2>Tipo:</h2>$client[tipo]</p>
                                <p><h2>Edad de su mascota:</h2>$client[edad]</p>
                                <div>
                                    <img src='../img/$client[foto]'>
                                </div>
                                
                                    
                                
                                
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