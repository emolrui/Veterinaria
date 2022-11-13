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
    <title>Productos</title>
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
                    echo "<p><a href='modificaciones/inserar_pro.php'><button type='submit' name='insertar'>
                                                Insertar
                                            </button>
                            </a>
                            </p>";
                }
            }
            


            if (isset($_POST['buscar'])) {
                $filtro=$_POST['filtro'];
                $mostrar1=" select * 
                            from producto
                            where nombre=? or precio=?";

                $consulta=$cone->prepare($mostrar1);
                $consulta->bind_param("si",$filtro,$filtro);
                $consulta->bind_result($id,$nombre,$precio);
                $consulta->execute();

                while ($consulta->fetch()) {
                    echo "
                        <div class='forma_cli'>
                            <p><h2>Nombre:</h2>$nombre</p>
                            <p><h2>Precio:</h2>$precio €</p>";
                            

                    if (isset($_COOKIE['Sesion_ejem'])) {
                        if ($_SESSION['nombre']=='admin') {
                            echo "<form action='modificaciones/modificar_pro.php' method='post'>
                                    <input type='hidden' name='id_modi' value=$id>
                                    <input type='submit' name='modific' value='Modificar'>
                                    
                                </form>
                                <form action='#' method='post'>
                                    <input type='hidden' name='id_modi' value=$id>
                                    <input type='submit' name='eliminar' value='Eliminar'>
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
                $mostrar1="select * from producto";

                $resultado= $cone->query($mostrar1);
                while ($product= $resultado->fetch_array(MYSQLI_ASSOC)) {
                    echo "
                        <div class='forma_cli'>
                            <p><h2>Nombre:</h2>$product[nombre]</p>
                            <p><h2>Precio:</h2>$product[precio] €</p>";
                    


                    if (isset($_COOKIE['Sesion_ejem'])) {
                        if ($_SESSION['nombre']=='admin') {
                            echo "<form action='modificaciones/modificar_pro.php' method='post'>
                                    <input type='hidden' name='id_modi' value=$product[id]>
                                    <input type='submit' name='modific' value='Modificar'>
                                    
                                </form>
                                <form action='#' method='post'>
                                    <input type='hidden' name='id_modi' value=$product[id]>
                                    <input type='submit' name='eliminar' value='Eliminar'>
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

            if (isset($_POST['eliminar'])) {
                $id_e=$_POST['id_modi'];
                $eliminar="delete from producto
                            where id=$id_e"; 


                $consulta_eli=$cone->query($eliminar);
                
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