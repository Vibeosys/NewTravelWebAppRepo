<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OptionController
 *
 * @author niteen
 */

use App\Model\Table;
class OptionsController extends AppController{
    public function getTableObj() {
        return new Table\OptionsTable();
    }
    public function getOptions($Id) {
        return $this->getTableObj()->getAll($Id);
    }
}
