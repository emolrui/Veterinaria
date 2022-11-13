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
    <title>Acceder</title>
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
        <div class="container">
                <div id="cabecera">
                    <h2>Rellena los datos para registrarse</h2>
                </div>

                    <form id="inscripcion" method="POST" action="#">

                        <div class="header">
                        
                            <h3>Inscribirse</h3>
                            
                            <p>Rellena este formulario</p>
                            
                        </div>
                        <div class="inputs">
                        
                            <input type="text" placeholder="nick" autofocus name="nombre" />
                            
                            <input type="password" placeholder="Contraseña" name="contraseña" class="contrasenia" />
                            
                            <div class="checkboxy">
                                <input name="cecky" id="checky" value="1" type="checkbox" /><label class="terms">Mantener sesion iniciada</label>
                            </div>
                            
                            <input type="submit" id="submit" value="Iniciar sesion" name="Iniciar_sesion">
                            <br/>
                            <input type="reset" value="Borrar información">
                        
                        </div>

                    </form>
                    <br>


        </div>

        <?php
            
            if (isset($_POST['Iniciar_sesion'])) {
                
                $nombre= $_POST['nombre'];
                $contraseña= $_POST['contraseña'];
                // $contraseña=md5($contraseña);

                $consulta="select nick
                            from dueño
                            where nick=? and pass=?";
                
                $inicio_ses=$cone->prepare($consulta);
                $inicio_ses-> bind_param("ss",$nombre,$contraseña);
                $inicio_ses->execute();

                $inicio_ses->store_result();
                echo $inicio_ses->num_rows;
                if ($inicio_ses->num_rows==0) {
                    echo "<div>Nombre o contraseña incorrectos pruebe de nuevo</div>";
                }else {
                    $_SESSION['nombre']=$nombre;
                    if (isset($_POST['cecky'])) {
                        $duracion=time()+60*60*24*30*6;
                    }else {
                        $duracion=0;
                    }

                    $codificacion=session_encode();

                    setcookie("Sesion_ejem",$codificacion,$duracion,"/");
                    echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
                }


                $inicio_ses->close();
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