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
class ClsAnswerDto {

    public $AnswerId;
    public $UserId;
    public $DestId;
    public $OptionId;
    public $CreatedDate;

    public function __construct($answerId, $userId, $destId, $optionId, $createdDate) {
        $this->AnswerId = $answerId;
        $this->UserId = $userId;
        $this->DestId = $destId;
        $this->OptionId = $optionId;
        $this->CreatedDate = $createdDate;
    }

}
