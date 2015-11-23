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
     ?>            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <button class="dark-orange add-dest-btn"><span>Add New Question</span></button>
                            </div><!-- /.box-header -->
                            <?php if(!empty($questions)){?>
                    <div class="paginate">
                        <span style="width:100px"> Page  <?= $this->Paginator->counter() ?></span>
                        <span ><button class="prev-span" ><?=  $this->Paginator->prev(' << ' . __('previous')) ?></button></span>
                        <span ><button class="next-span" ><?= $this->Paginator->next('next »') ?></button></span>
                    </div>     
                    <textarea id="next-page" class="hide-text"><?= $this->Paginator->hasNext()?></textarea>
                    <textarea id="prev-page" class="hide-text"><?= $this->Paginator->hasPrev()?></textarea>
                            <?php }?>
                            <div class="box-body show-grid-section">
                                <?php if(!empty($questions)){?>
                                <table id="destination" class="table table-bordered table-hover">
                                    <thead>
                                       
                                        <tr>
                                            <th>ID</th>
                                            <th class="title-width">Title</th>
                                            <th class="lat-width">Options</th>                                         
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                       <?php foreach ($questions as $question){?>
                                    <form action="edit" method="post">
                                        <tr>
                                            <td><?=h($question->questionId)?><input name="questionId" class="hide-text" type="number" value=<?=$question->questionId?>></td>
                                            <td class="title-width">
                                                <?=h($question->questionText)?><textarea name="questionText" class="hide-text"><?=$question->questionText?></textarea>
                                            </td>
                                            <td class="lat-width">
                                             <?=h($question->options)?><textarea class="hide-text" name="options"> <?=h($question->options)?></textarea>
                                            </td>
                                            <?php if($question->active){?>
                                            <td>Active</td><input class="hide-text" name="status" type="number" value=1>
                                            <td> <button type="submit" name="edit" value="edit" class="dark-orange add-edit-btn"><span> Edit</span></button> <button type="submit" name="delete" value="delete" class="light-orange"><span>Delete</span></button></td>
                                            <?php }else{?>
                                            <td>Inactive</td><input class="hide-text" name="status" type="number" value=0>
                                            <td> <button type="submit" name="edit" value="edit" class="dark-orange add-edit-btn"><span> Edit</span></button></td>
                                            <?php }?>
                                        </tr>
                                    </form>
                                        
                                       
                                    </tbody>
                                </table>
                                <?php }}else{?>
                                <div class="error-div"><div class="error-span"></div><h4>Sorry ! Questions are empty. please add Questions</h4></div>
                                   <?php }?>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
 <?php $this->end();?>