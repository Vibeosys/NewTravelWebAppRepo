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
                            <?php if(!empty($config)){?>
                             <div class="paginate">
                        <span style="width:100px"> Page  <?= $this->Paginator->counter() ?></span>
                        <span ><button class="prev-span" ><?=  $this->Paginator->prev(' << ' . __('previous')) ?></button></span>
                        <span ><button class="next-span" ><?= $this->Paginator->next('next »') ?></button></span>
                    </div>     
                    <textarea id="next-page" class="hide-text"><?= $this->Paginator->hasNext()?></textarea>
                    <textarea id="prev-page" class="hide-text"><?= $this->Paginator->hasPrev()?></textarea>
                            <?php }?>
                            <div class="box-body show-grid-section">
                                <?php
                                if(!empty($configs)){?>
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
                                        
                                            $srno = 1;
                                        foreach ($configs as $config){?>
                                        <form action="edit"method="get" id ="entity-form">
                                        <tr>
                                            <td><?= h($srno) ?></td>
                                                <td class="title-width">
                                                <?= h($config->key)?><textarea name="key" class="hide-text" type="text"><?=$config->key?></textarea>
                                                </td>
                                                <td class="title-width">
                                                <?= h($config->value)?>
                                                </td>
                                        <textarea name="value" class="hide-text" type="text" ><?=$config->value?></textarea>
                                        <td> 
                                        <button name="edit" value="edit" type="submit" class="dark-orange edit-dest-btn"><span> Edit</span></button> 
                                        </td>
                                        </tr>
                                        </form>
                                        <?php $srno++;}?>
                                    </tbody>
                                </table>
                                  <?php }else{?>
                            <div class="error-div"><div class="error-span"></div><h4>Sorry ! Configurations are empty. please add configurations</h4></div>
                        <?php }?>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        <?php $this->end();?>