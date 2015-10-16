<?php
namespace app\view;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageView
 *
 * @author niteen
 */
use Cake\View\View;
class ImageView extends View{
    
    public function initialize() {
        
        $this->loadHelper('MyUtils');
    }
    
}
