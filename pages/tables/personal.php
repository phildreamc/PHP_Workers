<?php
    require("../../build/sql/mysql.php");
    
    session_start();
    
    if(!isset($_SESSION['username'])){  
        header("Location:login.html");  
        exit();  
    } 
    
    if(is_null($_GET["name"])){
        die("错误");
    }
    $name = $_GET["name"];
    
    $a= new db($_SESSION['username']);
    $res_all = $a->getPersonalAll($name);
    $row_all = $res_all->fetch_array();
    $id = $row_all['id'];
    $duty = $row_all['duty'];
    $start = $row_all['start'];
    
    $use_days = $a->getPersonalUse($name);
    
    $now = date("Y-m-d");
    $date_start = explode('-',$now);
    $date_end = explode('-',$start);
    if($date_start[2]<$date_end[2]){
        $mon_num = abs($date_start[0] - $date_end[0]) * 12 + ($date_start[1] - $date_end[1]) -1;
    }else{
        $mon_num = abs($date_start[0] - $date_end[0]) * 12 + ($date_start[1] - $date_end[1]);
    }
    
    $days_get = $a->getDayNum($duty);
    $num = $days_get->fetch_array();
    $daynum = $num['days'];
    
    if($duty){
        $all_days = ($mon_num - 9) * $daynum + 13;
        if($mon_num<9){
            $all_days = 0;
        }
        $compare = strtotime($start);
        $change_date = strtotime("2017-9-1");
        if($compare<$change_date){
            $old_worker = true;
            $use_days+=6.51;
        }
    }else{
        $all_days = ($mon_num - 12) * $daynum + 11;
        if($mon_num<12){
            $all_days = 0;
        }
    }
    $work_years = floor($mon_num/12)+1;
    
    $left_days = bcsub($all_days,$use_days,2);
    
    if($work_years<2){
        $this_left = $left_days;
    }else{
        if($left_days>$mon_num%12 * $daynum){
            $this_left = $mon_num%12 * $daynum;
        }else{
            $this_left = $left_days;
        }
    }
    $before_left = round($left_days - $this_left,2);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">



  <!-- daterange picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
    #popLayer {
        display: none;
        background-color: #B3B3B3;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 10;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);/* 只支持IE6、7、8、9 */
    }

    #popBox {
        display: none;
        background-color: #FFFFFF;
        z-index: 11;
        width: 600px;
        height: 200px;
        position:fixed;
        top:0;
        right:0;
        left:0;
        bottom:0;
        margin:auto;
    }

    #popBox .close{
        text-align: right;
        margin-right: 5px;
        background-color: #F8F8F8;
    }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> <?php echo $name; ?><?php echo "（第".$work_years."个工作年）"; ?>
            <!-- <small class="pull-right">值班人员</small> -->
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>值班人员：<?php if($duty){echo "是";}else{echo "否";} ?></strong><br>
            工号：<?php echo $id; ?><br>
            转试用日期：<?php echo $start; ?><br>
            每月累计：<?php echo $daynum; ?><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>剩余可用年假：<?php echo $left_days; ?>天</strong>（本工作年：<?php echo $this_left; ?>天，之前剩余：<?php echo $before_left; ?>天）<br>
            已累计：<?php echo $mon_num; ?>个月<br>
            累计年假：<?php echo $all_days; ?>天<br>
            已用年假：<?php echo $use_days; ?>天<?php if($old_worker){echo "（18年前入职新旧年假过渡6.51天）";}?><br>
          </address>
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>编号</th>
              <th>开始日期</th>
              <th>结束日期</th>
              <th>备注</th>
              <th>年假天数</th>
            </tr>
            </thead>
            <tbody>
            <form action="">
            <?php
                $result = $a->getPersonal($name);
                while($row=$result->fetch_array()){
                    echo '<tr>';
                    echo '<td><input type="checkbox" name="vehicle" value='.$row['off_num'].'>'.$row['off_num'].'</td>';
                    echo '<td>'.$row['start_time'].'</td>';
                    echo '<td>'.$row['end_time'].'</td>';
                    if($row['remarks']){
                        echo '<td>加班</td>';
                    }else{
                        echo '<td>休假</td>';
                    }
                    $datetime_start = new DateTime($row['start_time']);
                    $datetime_end = new DateTime($row['end_time']);
                    $day = $datetime_start->diff($datetime_end)->days;
                    $days = intval($day)+1;
                    echo '<td>'.$days.'</td>';
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
            </form>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <button class="btn btn-default" onclick="personalDel()"><i class="fa fa-print"></i> 删除</button>
          <button type="button" class="btn btn-success pull-right" onclick="popAddBox()"><i class="fa fa-credit-card"></i> 添加
          </button>
          <div id="popLayer"></div>
            <div id="popBox">
                <div class="content">
                    <div class="box box-primary">
                    
                    <div class="box-body">
                      <!-- Date -->
                      <div class="form-group">
                        <label>年假日期</label>

                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" style="display:none;" id="name" value="<?php echo $name; ?>">
                          <input type="text" class="form-control pull-right" id="reservation">
                        </div>
                        <!-- /.input group -->
                      </div>
                      <!-- /.form group -->

                      <!-- Date and time range -->
                      
                      <!-- /.form group -->

                      <!-- Date and time range -->
                      <div class="form-group">

                        <div class="input-group">
                        <button type="button" class="btn btn-success pull-right" onclick="subAdd(1)">
                            <span>
                              <i class="fa fa-calendar"></i> 加班
                            </span>
                            
                          </button>
                          <button type="button" class="btn btn-success pull-right" onclick="subAdd(0)">
                            <span>
                              <i class="fa fa-calendar"></i> 休假
                            </span>
                            
                          </button>
                          <button type="button" class="btn btn-default pull-right" onclick="closeAddBox()" style="margin-right:200px;margin-left:100px;">
                            <span>
                              <i class="fa fa-calendar"></i> 取消
                            </span>
                            
                          </button>
                        </div>
                      </div>
                      <!-- /.form group -->

                    </div>
                    <!-- /.box-body -->
                  </div>
                </div>
            </div>
          <!--<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> 修改
          </button>-->
        </div>
      </div>
    </section>
<!-- ./wrapper -->
<script>
    /*点击弹出按钮*/
    function popAddBox() {
        var popBox = document.getElementById("popBox");
        var popLayer = document.getElementById("popLayer");
        popBox.style.display = "block";
        popLayer.style.display = "block";
    };
 
    /*点击关闭按钮*/
    function closeAddBox() {
        var popBox = document.getElementById("popBox");
        var popLayer = document.getElementById("popLayer");
        popBox.style.display = "none";
        popLayer.style.display = "none";
    }
    function subAdd(remarks){
        var name = document.getElementById("name").value;
        var reservation = document.getElementById("reservation").value;
        $.post('../../functions/personalAdd.php', { 'name': name,'date':reservation,'remarks':remarks}, function (text, status) 
            {
                window.location.reload();
            });
    }
    function personalDel(){
        var items = document.getElementsByName("vehicle");
        for (i = 0; i < items.length; i++) {                    
            if (items[i].checked) {                        
                $.post('../../functions/personalDel.php', { 'off_num': items[i].value}, function (text, status) 
            {
                window.location.reload();
            });            
            } 
        } 
    }
</script>

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>

<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="../../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../../plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>
<?php $a->disCon(); ?>