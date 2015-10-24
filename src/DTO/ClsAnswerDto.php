<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAnswerDto
 *
 * @author niteen
 */
class ClsAnswerDto extends JsonDeserializer{

    public $answerId;
    public $userId;
    public $destId;
    public $optionId;
    public $createdDate;

    public function __construct($userId = null, $destId = null, $optionId = null, $answerId = null, $createdDate = null) {
        $this->answerId = $answerId;
        $this->userId = $userId;
        $this->destId = $destId;
        $this->optionId = $optionId;
        $this->createdDate = $createdDate;
    }

}
