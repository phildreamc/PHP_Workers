<?php
    session_start();
    
    if(!isset($_SESSION['username'])){  
        header("Location:login.html");  
        exit();  
    } 
    
    $q = $_GET["q"];
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Starter</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="bower_components/mycss/iconfont.css">
  <link rel="stylesheet" href="bower_components/mycss/register.css">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
  
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        
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

    #popAddBox {
        display: none;
        background-color: #FFFFFF;
        z-index: 11;
        width: 500px;
        height: 248px;
        position:fixed;
        top:0;
        right:0;
        left:0;
        bottom:0;
        margin:auto;
    }

    #popAddBox .close{
        text-align: right;
        margin-right: 5px;
        background-color: #F8F8F8;
    }
</style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $_SESSION['username']; ?></b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->


      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" onkeyup="this.value=this.value.replace(/[^_a-zA-Z]/g,'')" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">选项</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="index.php?q="><i class="fa fa-link"></i> <span>首页</span></a></li>
        <li><a href="#"><i class="fa fa-link"></i> <span>薪资系统(暂无可用)</span></a></li>
        <li><a href="index.php?q=last_month"><i class="fa fa-link"></i> <span>上月年假</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>添加删除</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a onclick="popAddBox()">添加</a></li>
            <li><a data-toggle="modal" data-target="#modal-info">删除</a></li>
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content container-fluid" style="height:850px">
    <?php 
        if(!$q){
            echo '<iframe src="pages/tables/all.php" frameborder=0 width=100% height=100%>系统错误</iframe>';
        }else{
            if($q=="last_month"){
                echo '<iframe src="pages/tables/last_month.php" frameborder=0 width=100% height=100%>系统错误</iframe>';
            }else{
                echo '<iframe src="pages/tables/personal.php?name='.$q.'" frameborder=0 width=100% height=100%>系统错误</iframe>';
            }
        }
    ?>
      <!--------------------------
        | Your Page Content Here |
        -------------------------->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<div id="popLayer">
    <div id="popAddBox" style="display:none;">
        <div class="register-content">

        <form action="functions/personAdd.php" method="POST">
        <div class="register register1 active" style="display: block;">
            <div class="md_in">
                <input type="text" name="name" onkeyup="this.value=this.value.replace(/[^_a-zA-Z]/g,'')" id="regUserName" placeholder="姓名">
                <i class="iconfont icon-member"></i>
            </div>

            <div class="md_in">
                <input type="text" name="id" onkeyup="value=value.replace(/[^\d]/g,'')" id="regUserpwd" placeholder="工号">
                <i class="iconfont icon-card"></i>
            </div>

            <div class="md_in">
                值班: 是<input type="radio" name="duty" value="yes"> 否<input type="radio" name="duty" value="no"><br>
            </div>

            <div class="md_in">
                <input type="text" name="startDate" id="datepicker" placeholder="加入日期"><br>
                <i class="iconfont icon-shijian"></i>
            </div>
            <div class="md_in">
                <input type="submit" style="color:#D84315;margin-right:120px;margin-left:50px;"><input style="color:#D84315;" type="button" value="取消" id="cancel"></button>
            </div>
        </div>
        </form>

        </div>
    </div>
</div>
<!-- REQUIRED JS SCRIPTS -->

<div class="modal modal-info fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">删除员工信息</h4>
      </div>
      <form action="functions/personDel.php" method="POST">
      <div class="modal-body">
        删除：<input style="color:gray" type="text" name="name" onkeyup="this.value=this.value.replace(/[^_a-zA-Z]/g,'')" placeholder="姓名">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-outline">确定</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
<script>
$(function () {
    $('#datepicker').datepicker({
      autoclose: true
    })
})

/*点击弹出按钮*/
function popAddBox() {
    var popBox = document.getElementById("popAddBox");
    var popLayer = document.getElementById("popLayer");
    popBox.style.display = "block";
    popLayer.style.display = "block";
};

/*点击关闭按钮*/
function closeAddBox() {
    var popBox = document.getElementById("popAddBox");
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
$('#cancel').click(function(){
        closeAddBox();
    });

</script>
</body>
</html>