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
    <title>Servicios</title>
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

             echo "<form action='#' method='post'>
                    <label for='filtro'>Filtro:</label>
                    <input type='text' name='filtro'>
                    <input type='submit' name='buscar' value='buscar'>
                  </form>";
            if (isset($_COOKIE['Sesion_ejem'])) {
                if ($_SESSION['nombre']=='admin') {
                    echo "<p><a href='modificaciones/inserar_ser.php'><button type='submit' name='insertar'>
                                            Insertar
                                        </button>
                            </a>
                            </p>";
                }
            }
            
            


            if (isset($_POST['buscar'])) {
                $filtro=$_POST['filtro'];
                $mostrar1=" select * 
                            from servicio
                            where descripcion=?";

                $consulta=$cone->prepare($mostrar1);
                $consulta->bind_param("s",$filtro);
                $consulta->bind_result($id,$descripcion,$duracion,$precio);
                $consulta->execute();

                while ($consulta->fetch()) {
                    echo "
                        <div class='forma_cli'>
                            <p><h2>Nombre:</h2>$descripcion</p>
                            <p><h2>Duracion:</h2>$duracion minutos</p>
                            <p><h2>Precio:</h2>$precio €</p>";
                    if (isset($_COOKIE['Sesion_ejem'])) {
                        if ($_SESSION['nombre']=='admin') {
                            echo "<form action='modificaciones/modificar_ser.php' method='post'>
                                <input type='hidden' name='id_modi' value=$id>
                                <input type='submit' name='modific' value='Modificar'>
                                </form>       
                                </div> <br>";
                        }else {
                            echo "</div> <br>";
                        }
                    }else {
                        echo "</div> <br>";
                    }
                            
                }
                $consulta->close();
            }else{
                $mostrar1="select * from servicio";

                $resultado= $cone->query($mostrar1);
                while ($servici= $resultado->fetch_array(MYSQLI_ASSOC)) {
                    echo "
                        <div class='forma_cli'>
                            <p><h2>Nombre:</h2>$servici[descripcion]</p>
                            <p><h2>Duracion:</h2>$servici[duracion] minutos</p>
                            <p><h2>Precio:</h2>$servici[precio] €</p>";

                    if (isset($_COOKIE['Sesion_ejem'])) {
                        if ($_SESSION['nombre']=='admin') {
                            echo "<form action='modificaciones/modificar_ser.php' method='post'>
                                <input type='hidden' name='id_modi' value=$servici[id]>
                                <input type='submit' name='modific' value='Modificar'>
                                </form>       
                                </div> <br>";
                        }else {
                            echo "</div> <br>";
                        }
                    }else {
                        echo "</div> <br>";
                    }
    
                }
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