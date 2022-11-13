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
    <title>citas</title>
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
            echo "<meta http-equiv='refresh' content='0;url= ./acceder.php'>";
        }elseif ($_SESSION['nombre']=='admin') {
        
            /*Añadir citas */
            echo "<p><a href='modificaciones/inserar_cit.php'><button type='submit' name='insertar'>
                            Insertar
                        </button>
                    </a>
                </p>";

            setlocale(LC_ALL,"es-ES.UTF-8");
            $contador=0;
            $dia_hoy=date("d");
            $mes_hoy=date("n");
            $año_hoy=date("Y");
            $contadorDias=0;

            



            if (isset($_POST['siguiente'])) {
                $valor= $_POST['valor'];
                $año_actu=$_POST['año'];
                // $dias_anio_actual=$_POST['dias_'];
                // $contador=$dias_anio_actual;
                $año_hoy=$año_actu;
                $mes_hoy=$valor;
                $valor_mes_antes=$valor;
                $valor_mes_despues=$valor;
            }elseif(isset($_POST['anterior'])){
                $valor= $_POST['valor'];
                $año_actu=$_POST['año'];
                // $dias_anio_actual=$_POST['dias_'];
                // $contador=$dias_anio_actual;
                $mes_hoy=$valor;
                $valor_mes_antes=$valor;
                $valor_mes_despues=$valor;
                $año_hoy=$año_actu;
            }else {
                $valor_mes_antes=$mes_hoy;
                $valor_mes_despues=$mes_hoy;
                
            }
            
            if ($valor_mes_despues>12) {
                $año_hoy=$año_hoy+1;
                $mes_hoy=1;
                $valor_mes_despues=1;

            }elseif ($valor_mes_antes<1) {
                $año_hoy=$año_hoy-1;
                $mes_hoy=12;
                $valor_mes_antes=12;
            }
            $valor_mes_antes=$mes_hoy-1;
            $valor_mes_despues=$mes_hoy+1;


                /* Busqueda filtro nombre cli, fecha,servicio*/ 
            echo "<form action='#' method='post'>
                    <label for='filtro'>Filtro:</label>
                    <input type='text' name='filtro'>
                    <input type='submit' name='buscar' value='buscar'>
                    </form>";

            
            /*MES Y AÑO DEL CALENDARIO */
            $primerDia=mktime(0,0,0,$mes_hoy,1,$año_hoy);
            $forma_mes=strftime("%B",$primerDia);
            $mayuscula=ucfirst($forma_mes);
        
            echo"<h2>$mayuscula de $año_hoy</h2>";




            /*cALENDARIO */
            
            $dias_semana=array("Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado", "Domingo");
            echo"<table border><tr>";
            for ($i=0; $i < count($dias_semana); $i++) { 
                echo"<th>$dias_semana[$i]</th>";
            }
            echo"</tr><tr>";

            $primerDia=mktime(0,0,0,$mes_hoy,1,$año_hoy);
            $primerDiames=date("N",$primerDia);
            $diasMes=date("t","$primerDia");

            for($i=1;$i<$primerDiames;$i++){
                echo"<td> </td>";
                $contador++;
            }

            $citas_hoy="select day(fecha) from citas where month(fecha)=$mes_hoy and year(fecha)=$año_hoy ";
            $contenido_citas=$cone->query($citas_hoy);
            $a=array();
            $a[0]=0;
            while ( $color_cit=$contenido_citas->fetch_array(MYSQLI_ASSOC)) {
                $a[]=intval($color_cit['day(fecha)']);
            }

            for($j=1;$j<=$diasMes;$j++){
                $contador++;

                if($contador%6===0 or $contador%7===0){
                    echo"<td class='finde'>$j</td>";
                }elseif(array_search($j,$a)!=null){
                    echo"<td class='dia_cit'>$j</td>";
                }else{
                    echo"<td>$j</td>";
                }

                
                
                if($contador%7===0){
                    echo"</tr><tr>";
                    $contador=0;
                }
            }
            
            if($contador%7!=0){
                while($contador!=7){
                    echo"<td> </td>";
                    $contador++;
                    
                }
            }
        

            $contador=0;

            echo"</tr></table>";
            
            echo "<form action='#' method='post'>
                    <input type='hidden' name='valor' value='$valor_mes_despues'>
                    <input type='hidden' name='año' value='$año_hoy'>
                    <input type='hidden' name='dias_' value='$contadorDias'>
                    <input type='submit' name='siguiente' value='siguiente'>                             
                </form>";
            echo "<form action='#' method='post'>
                    <input type='hidden' name='valor' value='$valor_mes_antes'>
                    <input type='hidden' name='año' value='$año_hoy'>
                    <input type='hidden' name='dias_' value='$contadorDias'>
                    <input type='submit' name='anterior' value='anterior'>                             
                </form>";


            
            /*bUSCADOR  */
            if (isset($_POST['buscar'])) {
                $filtro=$_POST['filtro'];
                $mostrar=" select cliente.nombre, servicio.descripcion, citas.fecha , citas.hora
                            from cliente, servicio, citas
                            where cliente.id = citas.cliente and servicio.id = citas.servicio and 
                            (cliente.nombre=? or servicio.descripcion=? or citas.fecha=?) ";
                
                $consulta=$cone->prepare($mostrar);
                $consulta->bind_param("sss",$filtro,$filtro,$filtro);
                $consulta->bind_result($nombre_cliente,$nombre_servicio,$fecha_cita,$cita_hora);
                $consulta->execute();

                while ($consulta->fetch()) {
                    echo " <div class='forma_cli'>
                                <p>Nombre del cliente: $nombre_cliente</p>
                                <p>Descripcion del servicio: $nombre_servicio</p>
                                <p>Fecha de la cita: $fecha_cita</p>
                                <p>Hora de la cita:$cita_hora</p>
                                <form action='#' method='post'>
                                        <input type='hidden' name='clien_borr' value=$nombre_cliente>
                                        <input type='hidden' name='ser_borr' value=$nombre_servicio>
                                        <input type='hidden' name='fech_borr' value=$fecha_cita>
                                        <input type='hidden' name='hora_borr' value=$cita_hora>
                                        <input type='submit' name='eliminar' value='Eliminar'>
                                </form>
                            </div>";
                }
                $consulta->close();
            }else {
                $mostrar_cit="select cliente.nombre, servicio.descripcion, citas.fecha , citas.hora, cliente.id cli, servicio.id serv
                                from cliente, servicio, citas
                                where cliente.id = citas.cliente and servicio.id = citas.servicio";
                $resultado= $cone->query($mostrar_cit);
                while ($citt= $resultado->fetch_array(MYSQLI_ASSOC)) {
                    echo " <div class='forma_cli'>
                                <p>Nombre del cliente: $citt[nombre]
                                <p>Descripcion del servicio: $citt[descripcion]
                                <p>Fecha de la cita: $citt[fecha]
                                <p>Hora de la cita: $citt[hora]";

                    $fecha_hoy_ali=date('Y-m-d');
                    if ($citt['fecha']>$fecha_hoy_ali) {
                        echo "<form action='#' method='post'>
                                    <input type='hidden' name='clien_borr' value=$citt[cli]>
                                    <input type='hidden' name='ser_borr' value=$citt[serv]>
                                    <input type='hidden' name='fech_borr' value=$citt[fecha]>
                                    <input type='hidden' name='hora_borr' value=$citt[hora]>
                                    <input type='submit' name='eliminar' value='Eliminar'>
                                </form>";
                    }
                                
                    echo "</div> <br>";
                }
            }

            /*ELIMINAR CITAS */
            if (isset($_POST['eliminar'])) {
                $clien_borr=$_POST['clien_borr'];
                $ser_borr=$_POST['ser_borr'];
                $fech_borr=$_POST['fech_borr'];
                $hora_borr=$_POST['hora_borr'];
                
                $eliminar="delete from citas
                            where cliente=$clien_borr and servicio=$ser_borr and fecha='$fech_borr' and hora='$hora_borr' "; 

                $consulta_eli=$cone->query($eliminar);
                
            }
            //**************************DUEÑO**************************** */
        }elseif($_SESSION['nombre']!='admin') {

            setlocale(LC_ALL,"es-ES.UTF-8");
            $contador=0;
            $dia_hoy=date("d");
            $mes_hoy=date("n");
            $año_hoy=date("Y");
            $contadorDias=0;

            if (isset($_POST['siguiente'])) {
                $valor= $_POST['valor'];
                $año_actu=$_POST['año'];

                $año_hoy=$año_actu;
                $mes_hoy=$valor;
                $valor_mes_antes=$valor;
                $valor_mes_despues=$valor;
            }elseif(isset($_POST['anterior'])){
                $valor= $_POST['valor'];
                $año_actu=$_POST['año'];

                $mes_hoy=$valor;
                $valor_mes_antes=$valor;
                $valor_mes_despues=$valor;
                $año_hoy=$año_actu;
            }else {
                $valor_mes_antes=$mes_hoy;
                $valor_mes_despues=$mes_hoy;
                
            }
            
            if ($valor_mes_despues>12) {
                $año_hoy=$año_hoy+1;
                $mes_hoy=1;
                $valor_mes_despues=1;

            }elseif ($valor_mes_antes<1) {
                $año_hoy=$año_hoy-1;
                $mes_hoy=12;
                $valor_mes_antes=12;
            }
            $valor_mes_antes=$mes_hoy-1;
            $valor_mes_despues=$mes_hoy+1;


            /*MES Y AÑO DEL CALENDARIO */
            $primerDia=mktime(0,0,0,$mes_hoy,1,$año_hoy);
            $forma_mes=strftime("%B",$primerDia);
            $mayuscula=ucfirst($forma_mes);
        
            echo"<h2>$mayuscula de $año_hoy</h2>";




            /*cALENDARIO */
            
            $dias_semana=array("Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado", "Domingo");
            echo"<table border><tr>";
            for ($i=0; $i < count($dias_semana); $i++) { 
                echo"<th>$dias_semana[$i]</th>";
            }
            echo"</tr><tr>";

            $primerDia=mktime(0,0,0,$mes_hoy,1,$año_hoy);
            $primerDiames=date("N",$primerDia);
            $diasMes=date("t","$primerDia");

            for($i=1;$i<$primerDiames;$i++){
                echo"<td> </td>";
                $contador++;
            }

            $usuario=$_SESSION['nombre'];
            $citas_hoy="select day(citas.fecha) 
                        from citas,dueño,cliente 
                        where month(citas.fecha)=$mes_hoy and year(citas.fecha)=$año_hoy and  
                        citas.cliente=cliente.id and cliente.dni_dueño=dueño.dni and dueño.nick='$usuario'";
            $contenido_citas=$cone->query($citas_hoy);
            $a=array();
            $a[0]=0;
            while ( $color_cit=$contenido_citas->fetch_array(MYSQLI_ASSOC)) {
                $a[]=intval($color_cit['day(citas.fecha)']);
            }

            for($j=1;$j<=$diasMes;$j++){
                $contador++;

                if($contador%6===0 or $contador%7===0){
                    echo"<td class='finde'>$j</td>";
                }elseif(array_search($j,$a)!=null){
                    echo"<td class='dia_cit'>$j</td>";
                }else{
                    echo"<td>$j</td>";
                }

                
                
                if($contador%7===0){
                    echo"</tr><tr>";
                    $contador=0;
                }
            }
            
            if($contador%7!=0){
                while($contador!=7){
                    echo"<td> </td>";
                    $contador++;
                    
                }
            }
        

            $contador=0;

            echo"</tr></table>";
            
            echo "<form action='#' method='post'>
                    <input type='hidden' name='valor' value='$valor_mes_despues'>
                    <input type='hidden' name='año' value='$año_hoy'>
                    <input type='hidden' name='dias_' value='$contadorDias'>
                    <input type='submit' name='siguiente' value='siguiente'>                             
                </form>";
            echo "<form action='#' method='post'>
                    <input type='hidden' name='valor' value='$valor_mes_antes'>
                    <input type='hidden' name='año' value='$año_hoy'>
                    <input type='hidden' name='dias_' value='$contadorDias'>
                    <input type='submit' name='anterior' value='anterior'>                             
                </form>";





            $mostrar_cit="select cliente.nombre, servicio.descripcion, citas.fecha , citas.hora, cliente.id cli, servicio.id serv
                                from cliente, servicio, citas
                                where cliente.id = citas.cliente and servicio.id = citas.servicio";
                $resultado= $cone->query($mostrar_cit);
                while ($citt= $resultado->fetch_array(MYSQLI_ASSOC)) {
                    echo " <div class='forma_cli'>
                                <p>Nombre del cliente: $citt[nombre]
                                <p>Descripcion del servicio: $citt[descripcion]
                                <p>Fecha de la cita: $citt[fecha]
                                <p>Hora de la cita: $citt[hora]";

                    $fecha_hoy_ali=date('Y-m-d');
                    if (isset($_COOKIE['Sesion_ejem'])) {
                        if ($_SESSION['nombre']=='admin') {
                            if ($citt['fecha']>$fecha_hoy_ali) {
                                echo "<form action='#' method='post'>
                                            <input type='hidden' name='clien_borr' value=$citt[cli]>
                                            <input type='hidden' name='ser_borr' value=$citt[serv]>
                                            <input type='hidden' name='fech_borr' value=$citt[fecha]>
                                            <input type='hidden' name='hora_borr' value=$citt[hora]>
                                            <input type='submit' name='eliminar' value='Eliminar'>
                                        </form>";
                            }
                        }
                    }
                    
                                
                    echo "</div> <br>";
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