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
    <title>Noticias</title>
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
                
            
                echo "<p><a href='modificaciones/inserar_not.php'><button type='submit' name='insertar'>
                                                                        Insertar
                                                                    </button>
                            </a>
                    </p>";
                $limite=0;
                $desactivar_env=false;
                $desactivar_ant=false;
                if (isset($_POST['siguiente'])) {
                    $valor= $_POST['valor'];
                    $cont= $_POST['contador'];
                    $limite=$valor;
                    if ($cont<4) {
                        $desactivar_env=true;
                    }else {
                        $limite+=4;
                        $contador=0;
                    }
                    
                }elseif (isset($_POST['anterior'])) {
                    $valor= $_POST['valor'];
                    $limite=$valor;
                    if ($limite-4>=0) {
                        $limite-=4;
                    }else {
                        $desactivar_ant=true;
                    }
                }
                elseif(isset($_POST['limit_ver']))
                {
                    $limite = $_POST['limit_ver'];
                }
                    
        
                $mostrar1="select * from noticia limit $limite,4";

                $resultado= $cone->query($mostrar1);
                $numero_filas=$resultado->num_rows;

                $contador=0;

                echo "<section id='mae'>";
                while ($notic= $resultado->fetch_array(MYSQLI_ASSOC)) {
                    $contador++;
                    if (isset($_POST['ver']) && $_POST['ver_mas']==$notic['id']) {
                        
                        echo "
                            <article class='forma_not'>
                                    <p><h2>Titulo:</h2>$notic[titulo]</p>
                                    <p><h2>Contenido:</h2>$notic[contenido]</p>
                                    <p><h2>Fecha:</h2>$notic[fecha_publicacion]</p>
                                    <div>
                                        <img src='../img/$notic[imagen]'>
                                    </div>
                            </article>
                        ";
                    }else{
                        echo "
                            <article class='forma_not'>
                                    <p><h2>Titulo:</h2>$notic[titulo]</p>
                                    <h2>Contenido:</h2><p id='puntos_sus'>$notic[contenido]</p>
                                    <p><h2>Fecha:</h2>$notic[fecha_publicacion]</p>
                                    <form action='#' method='post'>
                                        <input type='hidden' name='ver_mas' value=$notic[id]>
                                        <input type='hidden' name='limit_ver' value='$limite'>
                                        <input type='submit' name='ver' value='ver más'>                               
                                    </form> 
                                    

                                    <div>
                                        <img src='../img/$notic[imagen]'>
                                    </div>
                            </article>
                        ";
                    }
                    
                        
                }

                echo "</section>";
                            
                if ( $desactivar_ant) {
                    echo "<form action='#' method='post'>
                            <input type='hidden' name='contador' value='$contador'>
                                <input type='hidden' name='valor' value='$limite'>
                                <input type='submit' name='anterior' value='anterior' disabled>
                                <input type='submit' name='siguiente' value='siguiente'>  
                                                             
                        </form>";
                }elseif ( $desactivar_env) {
                    echo "<form action='#' method='post'>
                            <input type='hidden' name='contador' value='$contador'>
                                <input type='hidden' name='valor' value='$limite'>
                                <input type='submit' name='anterior' value='anterior'> 
                                <input type='submit' name='siguiente' value='siguiente' disabled>  
                                                            
                        </form>";
                }else {
                    echo "<form action='#' method='post'>
                            <input type='hidden' name='contador' value='$contador'>
                                <input type='hidden' name='valor' value='$limite'>
                                <input type='submit' name='anterior' value='anterior'> 
                                <input type='submit' name='siguiente' value='siguiente'>  
                                                            
                        </form>";
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