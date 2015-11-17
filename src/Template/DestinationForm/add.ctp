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
                                                         
                                <section class="content content-div show-add-section">
                                    <div class="row">
                                        <!--Destination Form -->
                                        <div class="with-border box-header">

                                            <h3 class="box-title">Add New Destination</h3>
                                        </div><!-- /.box-header -->
                                        <!-- form start -->
                                        <form class="form-horizontal" action="add" method="post">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label for="Title" class="col-sm-2 control-label">Title</label>
                                                    <div class="col-sm-8">
                                                        <input name="tilte" type="text" class="form-control" id="Title" placeholder="Title" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="latitude" class="col-sm-2 control-label">Latitude</label>
                                                    <div class="col-sm-8">
                                                        <input name="latitude" type="text" class="form-control" placeholder="latitude" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="longitude" class="col-sm-2 control-label">Longitude</label>
                                                    <div class="col-sm-8">
                                                        <input name="longitude" type="text" class="form-control" placeholder="longitude" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input name="status" type="checkbox" > Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.box-body -->
                                            <div class="box-footer" style="margin-left:170px">
                                                <button name="cancel" type="button" class="light-orange add-cancel-btn">Cancel</button>
                                                <button name="save" type="submit" class="dark-orange add-save-btn">Save Destination</button>
                                            </div><!-- /.box-footer -->
                                        </form>
                                        <!-- /.box -->
                                        <!-- Destination form elements disabled -->
                                    </div>
                                </section>
                                
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
           <?php $this->end();?>