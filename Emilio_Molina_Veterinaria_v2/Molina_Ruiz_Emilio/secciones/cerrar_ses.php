<?php
    session_start();
    $_SESSION=array();
    session_destroy();

    setcookie("Sesion_ejem","",-1,"/");

    echo "<meta http-equiv='refresh' content='0;url=../index.php'>";



?>