<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApiController
 *
 * @author niteen
 */
class ApiController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->response->type('json');
    }

}
