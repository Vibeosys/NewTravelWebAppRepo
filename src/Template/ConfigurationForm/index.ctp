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
     $this->assign('title', 'Configuration');
     $this->assign('conf', 'class="active"');
     //$this->start('content');
     ?>
            
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <button class="dark-orange add-dest-btn"><span>Add New Configuration</span></button>
                            </div><!-- /.box-header -->
                            <div class="box-body show-grid-section">
                                <table id="destination" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="title-width">Key</th>
                                            <th class="title-width">Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(!empty($configs)){
                                            $srno = 1;
                                        foreach ($configs as $config){?>
                                        <form action="edit"method="get" id ="entity-form">
                                        <tr>
                                            <td><?= h($srno) ?></td>
                                                <td class="title-width">
                                                <?= h($config->key)?><input name="key" class="hide-text" type="text" value=<?=$config->key?>>
                                                </td>
                                                <td class="title-width"><?= h($config->value)?></td><input name="value" class="hide-text" type="text" value=<?=$config->value?>>
                                        <td> <button name="edit" value="edit" type="submit" class="dark-orange edit-dest-btn"><span> Edit</span></button> </td>
                                                 </tr>
                                        </form>
                                        <?php $srno++;}}else{echo 'Configuration list is empty';}?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        <?php $this->end();?>