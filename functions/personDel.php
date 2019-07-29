<?php
    require("../build/sql/mysql.php");
    
    session_start();
    
    if(!isset($_SESSION['username'])){  
        header("Location:login.html");  
        exit();  
    }
    
    $name = $_POST['name'];

    $a= new db($_SESSION['username']);
    $a->personDel($name);
    $a->disCon();
    $url = "../index.php?q=";
    echo "<script type='text/javascript'>";
    echo "window.location.href='".$url."'";
    echo "</script>"; 
?>