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
     $this->assign('title', 'Destination');
     //$this->start('content');
     ?>

                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">                           
                                <!--  Edit Destination Section -->
                                <section class="content content-div show-edit-section">
                                    <div class="row">
                                        <!--Destination Form -->
                                        <div class="with-border box-header">

                                            <h3 class="box-title">Edit Destination</h3>
                                        </div><!-- /.box-header -->
                                        <!-- form start -->
                                        <form class="form-horizontal" action="edit" method="POST">
                                            <div class="box-body"><input name="destId" type="number" class="hide-text" value=<?= $destinationEntity->destId?>>
                                                <div class="form-group">
                                                    <label for="Title" class="col-sm-2 control-label">Title</label>
                                                    <div class="col-sm-8">
                                                        <input name="title" type="text" class="form-control" id="Title" placeholder="Title" value=<?= $destinationEntity->destName?>>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="latitude" class="col-sm-2 control-label">Latitude</label>
                                                    <div class="col-sm-8">
                                                        <input name="latitude" type="text" class="form-control" placeholder="latitude" value=<?= $destinationEntity->lat?>>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="longitude" class="col-sm-2 control-label">Longitude</label>
                                                    <div class="col-sm-8">
                                                        <input name="longitude" type="text" class="form-control" placeholder="longitude" value=<?= $destinationEntity->long?>> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <div class="checkbox">
                                                            <label>
                                                                <?php if($destinationEntity->active){?>
                                                                <input name="status" type="checkbox" checked> Active  
                                                                <?php }else{?>
                                                                <input name="status" type="checkbox"> Active
                                                                <?php }?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.box-body -->
                                            <div class="box-footer" style="margin-left:170px">
                                                <button name="cancel" type="button" class="light-orange add-cancel-btn">Cancel</button>
                                                <button name="save" type="submit" class="dark-orange edit-save-btn">Save Destination</button>
                                            </div><!-- /.box-footer -->
                                        </form>
                                        
                                        <!-- /.box -->
                                        <!-- Destination form elements disabled -->
                                    </div>
                                </section>
                            </div><!-- /.box -->                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
<?php $this->end();?>
