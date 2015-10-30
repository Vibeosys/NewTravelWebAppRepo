<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use App\Controller;

$this->layout = false;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Configuration</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <?= $this->Html->css('bootstrap.min.css')?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <?= $this->Html->css('dataTables.bootstrap.css')?>
    <!-- Theme style -->
     <?= $this->Html->css('Style.css')?>
     <?= $this->Html->css('All-skins.css')?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="home" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>N</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Logo</b></span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <!--<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>-->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account -->
                        <li class="dropdown user user-menu">
                            <a href="../">
                                <img src="../webroot/img/user.png" class="user-image" alt="User Image">
                                <span class="hidden-xs">Sign Off</span>
                            </a>
                        </li>      
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar -->
            <section class="sidebar">              
                <!-- sidebar menu:  -->
                <ul class="sidebar-menu">                  
                    <li>
                        <a href="home">
                            <i class="icon dashboard"></i> <span>Dashboard</span>
                            <em></em>
                        </a>
                    </li>
                    <li>
                        <a href="../destination/index">
                            <i class="icon regions"></i> <span>Destinations</span>
                            <em></em>
                        </a>
                    </li>
                    <li>
                        <a href="../question/index">
                            <i class="icon channels"></i>  <span>Questions</span>
                            <em></em>
                        </a>
                    </li>
                    <li class="active">
                        <a href="../configuration/index">
                            <i class="icon products"></i>  <span>Configurations</span>
                            <em></em>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Configuration
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Configuration</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <section class="content content-div show-add-section">
                                <div class="row">
                                    <!--Destination Form -->
                                    <div class="with-border box-header">
                                        <h3 class="box-title">Edit Configuration</h3>
                                    </div><!-- /.box-header -->
                                    <!-- form start -->
                                    <form class="form-horizontal" action="edit" method="post">
                                        <?php if(!empty($config)){?>
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="Key" class="col-sm-2 control-label">Key</label>
                                                <div class="col-sm-8">
                                                    <input name="key" type="text" class="form-control" id="Key" placeholder="Key" value=<?= $config['key']?>>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Value" class="col-sm-2 control-label">Value</label>
                                                <div class="col-sm-8">
                                                    <input name="value" type="Value" class="form-control" placeholder="Value" value=<?= $config['value']?>>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                        <div class="box-footer" style="margin-left:170px">
                                            <button type="button" class="light-orange add-cancel-btn">Cancel</button>
                                            <button type="submit" class="dark-orange add-save-btn">Save Configuration</button>
                                        </div><!-- /.box-footer -->
                                        <?php }?>
                                    </form>
                                    <!-- /.box -->
                                    <!-- Destination form elements disabled -->
                                </div>
                            </section>
                            
                            
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2015-2016 <a href="#">Application Name</a>.</strong> All rights reserved.
        </footer>
    </div><!-- ./wrapper -->
    <!-- jQuery 2.1.4 -->
    <?= $this->Html->script('jQuery-2.1.4.min.js')?>
    <!-- Bootstrap 3.3.5 -->
    <?= $this->Html->script('bootstrap.min.js')?>
    <!-- DataTables -->
    <?= $this->Html->script('jquery.dataTables.js')?>
    <?= $this->Html->script('dataTables.bootstrap.min.js')?>
    <!-- SlimScroll -->
    <?= $this->Html->script('jquery.slimscroll.min.js')?>
    <!-- FastClick -->
 
    <?= $this->Html->script('Script.js')?>
    <!--<script src="../../dist/js/app.min.js"></script>-->
    <!-- AdminLTE for demo purposes -->
    <?= $this->Html->script('DestinationScript.js')?>
</body>
</html>
