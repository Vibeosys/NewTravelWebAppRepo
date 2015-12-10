<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use App\Controller;

$this->layout = false;

?>
 <?php
     $this->layout = 'travel_layout';
     $this->assign('title', 'Question');
     //$this->start('content');
     ?>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <section class="content content-div show-add-section">
                                <div class="row">
                                    <!--Destination Form -->
                                    <div class="with-border box-header">
                                        <h3 class="box-title">Add New Question</h3>
                                    </div><!-- /.box-header -->
                                    <!-- form start -->
                                    <form class="form-horizontal" method="POST" action="add">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="Title" class="col-sm-2 control-label">Title</label>
                                                <div class="col-sm-8">
                                                    <input name="questiontext" type="text" class="form-control" id="Title" placeholder="Title" required>
                                                </div>
                                            </div>
                                           
                                            <div class="form-group" id="options">
                                                <label for="Options" class="col-sm-2 control-label">Options</label>
                                                <div class="col-sm-8">
                                                   <!-- <input type="text" class="form-control"  value="" data-role="tagsinput" /> -->
                                                    <input name="options" type="text" class="form-control"  value="" data-role="tagsinput" />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input name="status" type="checkbox"> Active
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                        <div class="box-footer" style="margin-left:170px">
                                          <!--  <button type="button" id="add-option" value =2 class="dark-orange" >Add Options</button>
                                            <button type="button" id="remove-option"class="light-orange add-save-btn">Remove Options</button>-->
                                            <button type="button" class="light-orange add-cancel-btn">Cancel</button>
                                            <button type="submit" class="dark-orange add-save-btn">Save Question</button>
                                        </div><!-- /.box-footer -->
                                    </form>
                                    <!-- /.box -->
                                    <!-- Destination form elements disabled -->
                                </div>
                            </section>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
 <?php $this->end();?>