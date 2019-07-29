<?php 
require("config.php");
class db{
    private $con;
    function __construct($table){
        global $db_username,$db_password;
        $this->con =new mysqli("localhost",$db_username,$db_password,$table);
        if (!$this->con)
          {
          die('Could not connect: ' . mysql_error());
          }
    }
    function getAll(){
        $result = mysqli_query($this->con,"SELECT * FROM home");
        return $result;
    }
    function getPersonal($name){
        $result = mysqli_query($this->con,"SELECT * FROM dayoff where name ='".$name."' ORDER BY start_time ASC");
        return $result;
    }
    function getPersonalAll($name){
        $result = mysqli_query($this->con,"SELECT * FROM home where name ='".$name."'");
        return $result;
    }
    function getPersonalUse($name){
        $use = 0;
        $result  = $this->getPersonal($name);
        while($row=$result->fetch_array()){
            $datetime_start = new DateTime($row['start_time']);
            $datetime_end = new DateTime($row['end_time']);
            $day = $datetime_start->diff($datetime_end)->days;
            $days = intval($day)+1;
            $use += $days;
        }
        return $use;
    }
    function getPersonalLastUse($name){
        $last_use = 0;
        $result  = $this->getPersonal($name);
        while($row=$result->fetch_array()){
            $last_month = date('Y-m-t',strtotime('-1 month'));
            $last_mon_date = new DateTime($last_month);
            $datetime_start = new DateTime($row['start_time']);
            $date_start_str = $datetime_start->format('Y-m-d');
            $datetime_end = new DateTime($row['end_time']);
            $date_end_str = $datetime_end->format('Y-m-d');
            $date_last = explode('-',$last_month);
            $date_start = explode('-',$date_start_str);
            $date_end = explode('-',$date_end_str);
            if($date_end[0]==$date_last[0]){
                if($date_start[1]==$date_last[1]&&$date_end[1]==$date_last[1]){
                    $day = $datetime_start->diff($datetime_end)->days;
                    $days = intval($day)+1;
                    $last_use += $days;
                }else if($date_start[1]==$date_last[1]){
                    $day = $last_mon_date->diff($datetime_start)->days;
                    $days = intval($day)+1;
                    $last_use += $days;
                }else if($date_end[1]==$date_last[1]){
                    $day = $date_end[2];
                    $days = intval($day);
                    $last_use += $days;
                }
            }
        }
        return $last_use;
    }
    function personalAdd($name,$date_start,$date_end,$remarks){
        if(!mysqli_query($this->con,"INSERT INTO dayoff (name, start_time, end_time, remarks) VALUES ('".$name."', '".$date_start."', '".$date_end."', ".$remarks.")")){
            echo mysql_error();
        };
    }
    function getDayNum($duty){
        $result = mysqli_query($this->con,"SELECT days FROM duty where ifduty =".$duty);
        return $result;
    }
    function personalDel($off_num){
        if(!mysqli_query($this->con,"delete from dayoff where off_num = ".$off_num)){
            echo mysql_error();
        };
    }
    function personAdd($id,$name,$duty,$date_start){
        if(!mysqli_query($this->con,"INSERT INTO home (id, name, duty, start) VALUES (".$id.", '".$name."', ".$duty.", '".$date_start."')")){
            echo mysql_error();
        };
    }
    function personDel($name){
        if(!mysqli_query($this->con,"delete from home where name = '".$name."'")){
            echo mysql_error();
        };
        if(!mysqli_query($this->con,"delete from dayoff where name = '".$name."'")){
            echo mysql_error();
        };
    }
    function disCon(){
        mysqli_close($this->con);
    }
}
?>