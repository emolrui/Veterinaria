<?php
    
    function conectar(){
        $cone=new mysqli ("localhost","root","","veterinaria");
        $cone->set_charset("utf8");
        return $cone;
    }


    function crear_pie($para1="../",$para2=""){
        echo "
        <div class='mapa_web'>
                <h4>Datos Fiscales</h4>
                <ul>
                    <li>© Copyright 2021</li>
                    <li>Todos los derechos reservados</li>
                    <li>Granada</li>
                    <li>España</li>
                </ul> 
            </div> 
        <div class='mapa_web'>
            <h4>Redes Sociales</h4>
            <ul>
                <a href='https://twitter.com/home' target='_blank'><li>Twitter <i class='fab fa-twitter fa-lg' title='Twitter'></i></li></a>
                <a href='https://www.facebook.com/' target='_blank'><li>Facebook <i class='fab fa-facebook fa-lg' title='Facebook'></i></li></a>
                <a href='https://www.instagram.com/?hl=es' target='_blank'><li>Instagram <i class='fab fa-instagram fa-lg' title='Instagram'></i></li></a>
                <a href='https://mail.google.com/' target='_blank'><li>Gmail <i class='far fa-envelope' title='Gmail'></i></li></a>
            </ul> 
        </div>";
    }

    function crear_menu($para1="../",$para2=""){

        if (!isset($_SESSION['nombre'])) {
            echo"
            <nav id='menu'>
                <div id='logo'>
                    <a href='$para1"."index.php'><img src='$para1"."img/logo.png' alt=''></a>
                </div>
                <ul>
                    <li><a href='$para1"."index.php'>Inicio</a></li>
                    <li><a href='$para2"."productos.php'>Producto</a></li>
                    <li><a href='$para2"."servicios.php'>Servicio</a></li>
                    <li><a href='$para2"."acceder.php'>Iniciar Sesión</a></li>
                </ul>

            </nav>";
        }elseif ($_SESSION['nombre']=="admin"){
            echo"
            <nav id='menu'>
                <div id='logo'>
                    <a href='$para1"."index.php'><img src='$para1"."img/logo.png' alt=''></a>
                </div>
                <ul>
                    <li><a href='$para1"."index.php'>Inicio</a></li>
                    <li><a href='$para2"."clientes.php'>Clientes</a></li>
                    <li><a href='$para2"."productos.php'>Producto</a></li>
                    <li><a href='$para2"."servicios.php'>Servicio</a></li>
                    <li><a href='$para2"."testimonios.php'>Testimonio</a></li>
                    <li><a href='$para2"."noticias.php'>Noticia</a></li>
                    <li><a href='$para2"."citas.php'>Citas</a></li>
                    <li><a href='$para2"."dueños.php'>Dueños</a></li>
                    <li><a href='$para2"."cerrar_ses.php'>Cerrar Sesion</a></li>
                </ul>

            </nav>";
        }elseif($_SESSION['nombre']!="admin"){
            echo"
            <nav id='menu'>
                <div id='logo'>
                    <a href='$para1"."index.php'><img src='$para1"."img/logo.png' alt=''></a>
                </div>
                <ul>
                    <li><a href='$para1"."index.php'>Inicio</a></li>
                    <li><a href='$para2"."clientes.php'>Mis mascotas</a></li>
                    <li><a href='$para2"."productos.php'>Producto</a></li>
                    <li><a href='$para2"."servicios.php'>Servicio</a></li>
                    <li><a href='$para2"."dueños.php'>Mis datos personales</a></li>
                    <li><a href='$para2"."citas.php'>Mis citas</a></li>
                    <li><a href='$para2"."cerrar_ses.php'>Cerrar sesión</a></li>
                </ul>

            </nav>";
        }
        
    }

   




?>