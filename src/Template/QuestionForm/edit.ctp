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
                                        <h3 class="box-title">Edit Question</h3>
                                    </div><!-- /.box-header -->
                                    <!-- form start -->
                                    <?php if(!empty($questionId)){
                                        ?>
                                      
                                    <form class="form-horizontal" method="post" action="edit">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <input name="questionId" type="number" class="hide-text" value=<?= $questionId?> >
                                                <label for="Title" class="col-sm-2 control-label">Title</label>
                                                <div class="col-sm-8">
                                                    
                                                    <textarea rows=1 name="questiontext" class="form-control" id="Title" placeholder="Title" required><?= base64_decode($questionText)?></textarea>
                                                    
                                                </div>
                                            </div>
                                           
                                            <div class="form-group" id="options">
                                                <label for="Options" class="col-sm-2 control-label">Option</label>
                                                <div class="col-sm-8">
                                                  
                                                    <input name="options" type="text" class="form-control" data-role="tagsinput" value="<?= h($options)?>" />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <div class="checkbox">
                                                        <label><?php if($status){echo '<input name="status" type="checkbox" checked> Active';
                                                        }else{echo '<input name="status" type="checkbox"> Active';}?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                        <div class="box-footer" style="margin-left:170px">
                                          <!--  <button type="button" id="add-option" value =2 class="dark-orange" >Add Options</button>
                                            <button type="button" id="remove-option"class="light-orange add-save-btn">Remove Options</button>-->
                                            <button type="button" class="light-orange add-cancel-btn">Cancel</button>
                                            <button name="save" value="save" type="submit" class="dark-orange add-save-btn">Save Question</button>
                                        </div><!-- /.box-footer -->
                                    </form>
                                    <?php }?>
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