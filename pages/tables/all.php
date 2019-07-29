<?php 
    require("../../build/sql/mysql.php");
    
    session_start();
    
    if(!isset($_SESSION['username'])){  
        header("Location:login.html");
        exit();
    }
    
    $a= new db($_SESSION['username']);
    $duty_get = $a->getDayNum(1);
    $duty_num = $duty_get->fetch_array();
    $duty = $duty_num['days'];
    
    $unduty_get = $a->getDayNum(0);
    $unduty_num = $unduty_get->fetch_array();
    $unduty = $unduty_num['days'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>员工</th>
                  <th>值班人员</th>
                  <th>累计年假</th>
                  <th>已用年假</th>
                  <th>剩余年假</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                    $result = $a->getAll();
                    while($row=$result->fetch_array()){
                        $use = $a->getPersonalUse($row['name']);
                        $now = date("Y-m-d");
                        $date_start = explode('-',$now);
                        $date_end = explode('-',$row['start']);
                        if($date_start[2]<$date_end[2]){
                            $mon_num = abs($date_start[0] - $date_end[0]) * 12 + ($date_start[1] - $date_end[1]) -1;
                        }else{
                            $mon_num = abs($date_start[0] - $date_end[0]) * 12 + ($date_start[1] - $date_end[1]);
                        }
                        if($row['duty']){
                            if($mon_num >= 9){
                                $all_days = ($mon_num - 9) * $duty + 13;
                            }else{
                                $all_days = 0;
                            }
                            $compare = strtotime($row['start']);
                            $change_date = strtotime("2017-9-1");
                            if($compare<$change_date){
                                $use+=6.51;
                            }
                        }else{
                            if($mon_num >= 12){
                                $all_days = ($mon_num - 12) * $unduty + 11;
                            }else{
                                $all_days = 0;
                            }
                        }
                        
                        $left = bcsub($all_days,$use,2);
                        
                        if($mon_num >= 0){
                            if($row['duty']){
                                if($left > ($mon_num%12)*$duty){
                                    if($left-($mon_num%12)*$duty >= 1){
                                        $level = "warning";
                                    }else{
                                        $level = "safe";
                                    }
                                }else{
                                    $level = "safe";
                                }
                                if($level == "warning" && $mon_num%12 >= 3){
                                    $level = "wrong";
                                }
                                if($level == "warning" && $mon_num%12 < 3 && $left > (12+$mon_num%12)*$duty+1){
                                    $level = "wrong";
                                }
                            }else{
                                if($left > ($mon_num%12)*$unduty){
                                    if($left-($mon_num%12)*$unduty >= 1){
                                        $level = "warning";
                                    }else{
                                        $level = "safe";
                                    }
                                }else{
                                    $level = "safe";
                                }
                                if($level == "warning" && $mon_num%12 >= 3){
                                    $level = "wrong";
                                }
                                if($level == "warning" && $mon_num%12 < 3 && $left > (12+$mon_num%12)*$unduty+1){
                                    $level = "wrong";
                                }
                            }
                        }else{
                            $level = "safe";
                        }
                        
                        echo '<tr>';
                        if($level=="safe"){echo '<td><a href=personal.php?name='.$row['name'].'>'.$row['name'].'</a></td>';}
                        if($level=="warning"){echo '<td><a style="color:red;" href=personal.php?name='.$row['name'].'>'.$row['name'].'</a></td>';}
                        if($level=="wrong"){echo '<td><a style="color:#04B404;" href=personal.php?name='.$row['name'].'>'.$row['name'].'</a></td>';}
                        if($row['duty']){
                            echo '<td>是</td>';
                        }else{
                            echo '<td>否</td>';
                        }
                        
                        echo '<td>'.$all_days.'</td>';
                        echo '<td>'.$use.'</td>';
                        echo '<td>'.$left.'</td>';
                        echo '</tr>';
                    }
                    
                    // while($row=$result->fetch_array()){
                        // echo htmlentities('<th>'.$row['name'].'</th>');
                        // echo htmlentities('<th>'.$row['duty'].'</th>');
                        // echo htmlentities('<th>'.$row['all_days'].'</th>');
                        // echo htmlentities('<th>'.$row['use_days'].'</th>');
                        // echo htmlentities('<th>'.$row['all_days']-$row['use_days'].'</th>');
                    // }
                ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
<?php $a->disCon(); ?>