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

    public $AnswerId;
    public $UserId;
    public $DestId;
    public $OptionId;
    public $CreatedDate;

    public function __construct($userId, $destId, $optionId,$answerId = null, $createdDate = null) {
        $this->AnswerId = $answerId;
        $this->UserId = $userId;
        $this->DestId = $destId;
        $this->OptionId = $optionId;
        $this->CreatedDate = $createdDate;
    }

}
