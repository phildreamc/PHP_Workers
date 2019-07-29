<?php
    require("../build/sql/mysql.php");
    
    session_start();
    
    if(!isset($_SESSION['username'])){  
        header("Location:login.html");  
        exit();  
    }
    
    $name = $_POST['name'];
    $id = $_POST['id'];
    $startDate = $_POST['startDate'];
    $duty = $_POST['duty'];
    if($duty=="yes"){
        $is_duty = 1;
    }else{
        $is_duty = 0;
    }
    $date_start = dateChange($startDate);

    $a= new db($_SESSION['username']);
    $a->personAdd($id,$name,$is_duty,$date_start);
    $a->disCon();
    function dateChange($dateStr){
        $str = explode("/",$dateStr);
        $newStr = $str[2]."/".$str[0]."/".$str[1];
        return $newStr;
    }
 
    $url = "../index.php?q=";
    echo "<script type='text/javascript'>";
    echo "window.location.href='".$url."'";
    echo "</script>"; 

?>