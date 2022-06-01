<?php
/*
 * Copyright (c) 2022. New Cloud | Pomelo
 * Email: <2284186613@qq.com>.
 * ProjectName:<New Cloud | PHP_Robot>
 * Developer:["Pomelo","LoYin"];
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/Robot.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils/com.newcloud/RobotInterface.php';//加载实现接口！！！！！必须导入
/**
 * 框架默认接口
 */
include_once $_SERVER['DOCUMENT_ROOT'] ."/utils/com.pomelo/HandleUtils.php";//引入官方工具类示例
/**
 * 群组控制器模板
 */
class GroupControllerModel extends Robot implements RobotInterface {
    public function main(){
    }
}