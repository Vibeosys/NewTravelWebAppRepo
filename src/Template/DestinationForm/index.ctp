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
                <div class="box-header">
                    <button class="dark-orange add-dest-btn" onclick="addDest()"><span>Add New Destination</span></button>
                </div><!-- /.box-header -->
                <?php if(!empty($dest)){?>
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
                                        if(!empty($dest)){?>
                    <table id="destination" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="title-width">Title</th>
                                <th class="lat-width">latitude</th>
                                <th class="lat-width">longitude</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                        
                                        <?php foreach ($dest as $destination){?>

                        <form action="edit"method="get" id ="entity-form">
                            <tr>
                                <td><?= h($destination->destId)?><input name="destId" class="hide-text" type="number" value=<?=$destination->destId?>></td>
                                <td class="title-width"><?= h($destination->destName)?>
                                <td class="lat-width"><?= h($destination->lat)?></td>
                                <td class="lat-width"><?= h($destination->long)?></td>
                                            <?php if($destination->active){ ?>
                                <td>Active</td>
                                <td> <button type="submit" class="dark-orange edit-dest-btn"><span> Edit</span></button> <button name="delete" value="delete" class="light-orange add-delete-btn"><span>Delete</span></button></td>
                                            <?php }else{ ?>
                                <td>Inactive</td>
                                <td> <button type="submit" class="dark-orange edit-dest-btn"><span> Edit</span></button></td>
                                            <?php }?>
                            </tr>
                        </form>
                                      <?php }?>

                        </tbody>
                    </table>
                    <?php }else{?>
                    <div class="error-div"><div class="error-span"></div><h4>Sorry ! Questions are empty. please add Questions</h4></div>
                        <?php }?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->                       
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
            <?php $this->end();?>

