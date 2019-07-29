<?php
    require("../build/sql/mysql.php");
    session_start();
    
    if(!isset($_SESSION['username'])){  
        header("Location:login.html");  
        exit();  
    }
    $off_num = $_POST['off_num'];
    $a= new db($_SESSION['username']);
    $a->personalDel($off_num);
    $a->disCon();
?>