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
    <title>Testimonio</title>
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
         
            if ($_SESSION['nombre']=='admin') {
                
            
                echo "<p><a href='modificaciones/inserar_tes.php'><button type='submit' name='insertar'>
                                                                                Insertar
                                                                            </button>
                        </a>
                    </p>";

                $mostrar1="select dueño.nombre, testimonio.contenido, testimonio.fecha 
                            from testimonio, dueño
                            where testimonio.dni_autor=dueño.dni
                            order by fecha desc";

                    $resultado= $cone->query($mostrar1);
                    while ($testim= $resultado->fetch_array(MYSQLI_ASSOC)) {
                        echo "
                            <div class='forma_cli'>
                                <p><h2>Autor:</h2>$testim[nombre]</p>
                                
                                <p><h2>Contenido:</h2>$testim[contenido] </p>
                                
                                <p><h2>Fecha:</h2>$testim[fecha]</p>    
                            </div>
                            <br>
                            ";
        
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
            echo crear_pie();
            $cone->close();
        ?>

    </footer>
    
</body>
</html>