<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Indice</title>
</head>
<body>
    <header>
        <?php
            require_once("funciones/funciones.php");
            $cone =conectar();
            $para1="";
            $para2="secciones/";
            echo crear_menu($para1,$para2);
        ?>
        
        
    </header>

    <main>
        <section id="noticiario">
            <h1>Noticias:</h1>
            <?php 
            $hoy=date("Y-m-d");
            $mostrar1="select * 
                        from noticia 
                        where noticia.fecha_publicacion < '$hoy'
                        order by fecha_publicacion desc
                        limit 0,3";
            $resultado= $cone->query($mostrar1);
            
            
            echo "<section id='mae'>";
            while ($notic= $resultado->fetch_array(MYSQLI_ASSOC)) {
         
                if (isset($_POST['ver']) && $_POST['ver_mas']==$notic['id']) {

                    echo "
                        <article class='forma_not'>
                                <p><h2>Titulo:</h2>$notic[titulo]</p>
                                <p><h2>Contenido:</h2>$notic[contenido]</p>
                                <p><h2>Fecha:</h2>$notic[fecha_publicacion]</p>
                                <div>
                                    <img src='img/$notic[imagen]'>
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
                                    <input type='submit' name='ver' value='ver más'>                               
                                </form> 
                                

                                <div>
                                    <img src='img/$notic[imagen]'>
                                </div>
                        </article>
                    ";
                }
                
                    
            }

            ?>
        </section>

        <section id="testimo">
            <h1>Testimonio:</h1>
            <?php
                $ids="select id from testimonio";
                $contenido_id=$cone->query($ids);
                while ($id_aleatorio=$contenido_id->fetch_array(MYSQLI_NUM)) {
                    $todos_ids[]=$id_aleatorio[0];
                }
                                
                $posiciones=count($todos_ids);
                $posiciones--;
                
                $aleatorio=rand(0,$posiciones);
                $mostrar1="select dueño.nombre, testimonio.contenido, testimonio.fecha 
                from testimonio, dueño
                where testimonio.dni_autor=dueño.dni and id= $todos_ids[$aleatorio] ";

                $resultado= $cone->query($mostrar1);
                while ($testim= $resultado->fetch_array(MYSQLI_ASSOC)) {
                    echo "
                        <div class='forma_cli'>
                            <p><h2>Autor:</h2>$testim[nombre]</p>
                            <br>
                            <p><h2>Contenido:</h2>$testim[contenido] </p>
                            <br>
                            <p><h2>Fecha:</h2>$testim[fecha]</p>    
                        </div>
                        <br>
                        ";
    
                }

            ?>
        </section>
        <form method="POST" action="#">
        <fieldset>
        <legend>Consulta</legend>
        <label for="nomb">Introduzca su nombre</label>
        <input type="text" name="nomb">
        <br>
        <label for="edad">Introduzca su edad</label>
        <input type="number" name="edad">
        <br>
        <label for="nomb_masc">Introduce el nombre de su mascota</label>
        <input type="text" name="nomb_masc">
        <br>
        <label for="motivo">Indique el motivo de su consulta</label>
        <textarea name="motivo"></textarea>
        <input type="submit" name="enviar">
        </fieldset>
        </form>
        <br>
        

    </main>

    <footer>
        <?php
            echo crear_pie($para1,$para2);
            $cone->close();
        ?>
    </footer>
</body>
</html>