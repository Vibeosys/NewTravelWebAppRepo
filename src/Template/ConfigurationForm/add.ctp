<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use App\Controller;



?>


    <?php
     $this->layout = 'travel_layout';
     $this->assign('title', 'Configuration');
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
                                        <h3 class="box-title">Add New Configuration</h3>
                                    </div><!-- /.box-header -->
                                    <!-- form start -->
                                    <form class="form-horizontal" action="add" method="POST">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="Key" class="col-sm-2 control-label">Key</label>
                                                <div class="col-sm-8">
                                                    <input name="key" type="text" class="form-control" id="Key" placeholder="Key" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Value" class="col-sm-2 control-label">Value</label>
                                                <div class="col-sm-8">
                                                    <input name="value" type="text" class="form-control" placeholder="Value" required>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                        <div class="box-footer" style="margin-left:170px">
                                            <button type="button" class="light-orange add-cancel-btn">Cancel</button>
                                            <button type="submit" class="dark-orange add-save-btn">Save Configuration</button>
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
        <!-- /.content-wrapper -->
<?php $this->end();?>