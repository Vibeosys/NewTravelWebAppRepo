<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use App\Controller;
use App\DTO;
use Cake\Network;

$this->layout = false;


?>
 <?php
     $this->layout = 'travel_layout';
     $this->assign('title', 'Admin Panel');
     
     //$this->start('content');
     ?>



                <!-- Content Header (Page header) -->
               
                <!-- Main content -->
                
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box"> 
                                <div class="home-header"><h1 class="admin-flash-h1">WelCome to <span class="app-name"><i> Safer<span class="app-name-select"> Ka Sathi </span></i></span></h1>
                                </div>
                                <div id="admin-flash-img" class="admin-flash-img">
                                </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->                       
                        </div><!-- /.col -->
                    
                <!-- /.content -->
                 <?php $this->end();?>