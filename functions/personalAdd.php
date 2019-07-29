<?php
    require("../build/sql/mysql.php");
    session_start();
    
    if(!isset($_SESSION['username'])){  
        header("Location:login.html");  
        exit();  
    }
    
    $name = $_POST['name'];
    $date = $_POST['date'];
    $dateArr = explode(" - ",$date);
    $start = $dateArr[0];
    $end = $dateArr[1];
    $date_start = dateChange($start);
    $date_end = dateChange($end);
    echo $date_start;
    
    $remarks = $_POST['remarks'];

    $a= new db($_SESSION['username']);
    $a->personalAdd($name,$date_start,$date_end,$remarks);
    $a->disCon();
    
    function dateChange($dateStr){
        $str = explode("/",$dateStr);
        $newStr = $str[2]."/".$str[0]."/".$str[1];
        return $newStr;
    }
?>