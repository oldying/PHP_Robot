<?php
/*
 * Copyright (c) 2022. New Cloud | Pomelo
 * Email: <2284186613@qq.com>.
 * ProjectName:<New Cloud | PHP_Robot>
 * Developer:["Pomelo","LoYin"];
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/Robot.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils/com.newcloud/RobotInterface.php';
/**
 * 框架默认接口
 */
include_once  $_SERVER['DOCUMENT_ROOT'] ."/utils/com.pomelo/HandleUtils.php";//引入官方工具类示例
/**
 * 私信控制器模板
 */
class PrivateControllerModel extends robot implements RobotInterface {
    public function main(){
    }
}
