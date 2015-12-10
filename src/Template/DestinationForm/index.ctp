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
                    <div class="col-xs-4" style="">
                    <button class="dark-orange add-dest-btn" onclick=""><span>Add New Destination</span></button></div>
                    <form action="index" method="post">
                        
                        <div class="col-xs-5 autocomplete">                      
                            <input id="autocomplete" type="search" name="dest" placeholder="search" required>
                            <!--<button id="searchbtn" class="btn dark-orange" name="search" type="submit">search</button>-->
                            </div>
                    </form>
                    <div class="col-xs-3" id="pagination">
                        <span id="prev-btn" ><button class="dark-orange" ><?=  $this->Paginator->prev(' << ' . __('previous')) ?></button></span>
                        <span id="next-btn" ><button class="dark-orange" ><?= $this->Paginator->next('next »') ?></button></span>
                    </div>
                </div><!-- /.box-header -->
                <?php if(!empty($dest)){
                    if(!empty($status)){?>
                         <input style="display: none" id="status" type="text" value="<?= $status?>">
                    <?php }?>
                    <textarea id="next-page" style="display: none"><?= $this->Paginator->hasNext()?></textarea>
                    <textarea id="prev-page" style="display: none"><?= $this->Paginator->hasPrev()?></textarea>
                <?php }?>
                <div class="box-body show-grid-section">
                    <?php
                                        if(!empty($dest)){?>
                    <table id="destination" class="table table-bordered table-hover dataTable no-footer" role="grid">
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
                                <td><?= h($destination->destId)?><input name="destId" style="display: none" type="number" value=<?=$destination->destId?>></td>
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
                    <div class="col-xs-6 no-of-page" ><b> No of Destinations : <?=$totalNumberOfDest?></b></div>
                    <div class="col-xs-6 page-counter" ><b> Page  <?= $this->Paginator->counter() ?></b></div>
                    <?php }else{?>
                    <div class="error-div"><div class="error-span"></div><h4><?= h($message)?></h4></div>
                        <?php }?>
                    <div class="demo"></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->                       
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->

            <?php $this->end();?>

