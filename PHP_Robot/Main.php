<?php
/*
 * Copyright (c) 2022. New Cloud | Pomelo
 * Email: <2284186613@qq.com>.
 * ProjectName:<New Cloud | PHP_Robot>
 * Developer:["Pomelo","LoYin"];
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/include/Robot.php';
class Main extends Robot
{
    /**
     * main constructor.
     * @param $flow
     */
    public function RobotMain($flow)
    {
        echo "OK!";
        fastcgi_finish_request();
        try {
            self::logs($flow);
            $flow = json_decode($flow);
            if($flow->message_type == 'private'){
                //加载词库
                $dirname = './thesaurus/private/';
                $dir_handle = opendir($dirname);
                while ($file = readdir($dir_handle)) {
                    if ($file != "." && $file != "..") {
                        $dirFile = $dirname . "/" . $file;
                        $className=basename($dirFile,".php");
                        @include_once $dirFile;
                        @$object = new $className();
                        @$object->setMessage($flow->raw_message);
                        @$object->setUserId($flow->user_id);
                        @$object->setSelfId($flow->self_id);
                        @$object->setMessageId($flow->message_id);
                        @$object->setCompleteMessage($flow->message);
                        @$object->setNickname($flow->sender->nickname);
                        @$object->setMessageType($flow->message_type);
                        @$object->main();
                    }
                }
            }else if($flow->message_type == 'group'){
                //查询授权群
                $group_AuthFlag=false;
                foreach (self::$AUTH_GROUP as $item=>$value){
                    if($value==$flow->group_id){
                        $group_AuthFlag=true;
                    }
                }
                if(!$group_AuthFlag)return;
                //加载词库
                $dirname = './thesaurus/group/';
                $dir_handle = opendir($dirname);
                while ($file = readdir($dir_handle)) {
                    if ($file != "." && $file != "..") {
                        $dirFile = $dirname . "/" . $file;
                        $className=basename($dirFile,".php");
                        @include_once $dirFile;
                        @$object = new $className();
                        @$object->setMessage($flow->raw_message);
                        @$object->setUserId($flow->user_id);
                        @$object->setSelfId($flow->self_id);
                        @$object->setMessageId($flow->message_id);
                        @$object->setNickname($flow->sender->nickname);
                        @$object->setGroupId($flow->group_id);
                        @$object->setCard($flow->sender->card);
                        @$object->setMessageType($flow->message_type);
                        @$object->setCompleteMessage($flow->message);
                        @$object->main();
                    }
                }
            }else{
                $dirname = './thesaurus/request/';
                $dir_handle = opendir($dirname);
                while ($file = readdir($dir_handle)) {
                    if ($file != "." && $file != "..") {
                        $dirFile = $dirname . "/" . $file;
                        $className=basename($dirFile,".php");
                        @include_once $dirFile;
                        @$object = new $className();
                        @$object->flow=$flow;
                        @$object->main();
                    }
                }
                if($flow->meta_event_type=="heartbeat"){
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/logs/list/'.$flow->self_id.'.log');
                    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/logs/list/'.$flow->self_id.'.log', json_encode($flow) . PHP_EOL, FILE_APPEND);
                }
            }
        }catch (Throwable $throwable){
            if(self::$DEBUG){
                $this->sendPrivateMsg(self::$MASTER,"PHP脚本出现异常:\r\n错误信息:".$throwable->getMessage()."\r\n报错文件：".$throwable->getFile()."\r\n报错行数:".$throwable->getLine());
            }
        }
    }
    public static function logs($flow){
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/logs/heartbeat/'.time(), $flow . PHP_EOL, FILE_APPEND);
        $fileList=array();
        $dirname = $_SERVER['DOCUMENT_ROOT'].'/logs/heartbeat/';
        $dir_handle = opendir($dirname);
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                array_push($fileList,$file);
            }
        }
        rsort($fileList);
        foreach ($fileList as $key=>$value){
            if($key>=15){
                unlink($dirname.$value);
            }
        }
    }


    /**
     * @param $message
     * @return main
     * 启动入口
     */
    public static function start($flow): main
    {

        //判断是否为空
        if ($flow == null) {
            exit("请不要直接访问接口！！！！！");
        } else {
            $Main= new Main();

            $Main->RobotMain($flow);
            return $Main;
        }
    }
}
Main::start(file_get_contents('php://input'));
