<?php
/*
 * Copyright (c) 2022. New Cloud | Pomelo
 * Email: <2284186613@qq.com>.
 * ProjectName:<New Cloud | PHP_Robot>
 * Developer:["Pomelo","LoYin"];
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/Transaction.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/Robot.php';
class ProcessingControllerModel extends Transaction
{
    public $flow;//消息流
    public function main()
    {
    }
}