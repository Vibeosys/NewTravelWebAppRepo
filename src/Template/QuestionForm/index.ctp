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
    <title>Question</title>
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
            <a href="../home" class="logo">
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
                        <a href="../home">
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
                    <li class="active">
                        <a href="../questions/index">
                            <i class="icon channels"></i>  <span>Questions</span>
                            <em></em>
                        </a>
                    </li>
                    <li>
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
                    Questions
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../home"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Questions</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <button class="dark-orange add-dest-btn"><span>Add New Question</span></button>
                            </div><!-- /.box-header -->
                            <div class="box-body show-grid-section">
                                <table id="destination" class="table table-bordered table-hover">
                                    <thead>
                                       
                                        <tr>
                                            <th>ID</th>
                                            <th class="title-width">Title</th>
                                            <th class="lat-width">Options</th>                                         
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($questions)){
                                        foreach ($questions as $question){?>
                                    <form action="edit" method="get">
                                        <tr>
                                            <td><?=h($question->questionId)?><input name="questionId" class="hide-text" type="number" value=<?=$question->questionId?>></td>
                                            <td class="title-width">
                                                <?=h($question->questionText)?><textarea name="questionText" class="hide-text"><?=$question->questionText?></textarea>
                                            </td>
                                            <td class="lat-width"><?=h($question->options)?></td>
                                            <?php if($question->active){?>
                                            <td>Active</td><input class="hide-text" name="status" type="number" value=0>
                                            <td> <button type="submit" name="edit" value="edit" class="dark-orange add-edit-btn"><span> Edit</span></button> <button type="submit" name="delete" value="delete" class="light-orange"><span>Delete</span></button></td>
                                            <?php }else{?>
                                            <td>Inactive</td><input class="hide-text" name="status" type="number" value=1>
                                            <td> <button type="submit" name="edit" value="edit" class="dark-orange add-edit-btn"><span> Edit</span></button></td>
                                            <?php }?>
                                        </tr>
                                    </form>
                                        <?php }}?>
                                       
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
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
    <?= $this->Html->script('DestinationScript.js')?>
    <!-- Bootstrap 3.3.5 -->
    <?= $this->Html->script('bootstrap.min.js')?>
    <!-- DataTables -->
    <?= $this->Html->script('jquery.dataTables.js')?>
    <?= $this->Html->script('dataTables.bootstrap.min.js')?>
    <!-- SlimScroll -->
    <?= $this->Html->script('jquery.slimscroll.min.js')?>
    <!-- FastClick -->
    <?= $this->Html->script('fastclick.min.js')?>
    <?= $this->Html->script('Script.js')?>
    <!--<script src="../../dist/js/app.min.js"></script>-->
    <!-- AdminLTE for demo purposes -->
    
</body>
</html>
