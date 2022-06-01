<?php
/*
 * Copyright (c) 2022. New Cloud | Pomelo
 * Email: <2284186613@qq.com>.
 * ProjectName:<New Cloud | PHP_Robot>
 * Developer:["Pomelo","LoYin"];
 */
@$io=file_get_contents( $_SERVER['DOCUMENT_ROOT']."/Config.json");
@$io=json_decode($io);
Robot::$HOST=$io->HOST;
Robot::$PORT=$io->PORT;
Robot::$MASTER=$io->MASTER;
Robot::$DEBUG=$io->DEBUG;
Robot::$AUTH_GROUP=$io->AUTH_GROUP;
Robot::$SAFE_MODE=$io->SAFE_MODE;
unset($io);
class Robot
{
    public static $HOST;//服务端监听地址
    public static $PORT;//服务端监听端口
    public static $MASTER ;//主人QQ号码
    public static $DEBUG;//是否开启调试模式
    public static $AUTH_GROUP;//授权的QQ群号码
    public static $SAFE_MODE;//是否开启安全模式

    private $message;//发送的信息
    private $user_id;//QQ号码
    private $self_id;//自己的QQ号码
    private $nickname;//昵称
    private $group_id;//群号码
    private $card;//群名片
    private $message_id;//消息ID
    private $message_type;//消息类型

    private $complete_message;

    /**
     * @return mixed
     */
    public function getCompleteMessage()
    {
        return $this->complete_message;
    }

    /**
     * @param mixed $complete_message
     */
    public function setCompleteMessage($complete_message)
    {
        $this->complete_message = $complete_message;
    }//完整的消息

    /**
     * @param mixed $message_type
     */
    public function setMessageType($message_type)
    {
        $this->message_type = $message_type;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getSelfId()
    {
        return $this->self_id;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getGroupId()
    {
        if($this->message_type== 'private'){
            return "私聊无法获取群号码！";
        }
        return $this->group_id;
    }

    /**
     * @return mixed
     */
    public function getCard()
    {
        if($this->message_type== 'private'){
            return "私聊无法获取群卡片名称！";
        }
        return $this->card;
    }

    /**
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->message_id;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param mixed $self_id
     */
    public function setSelfId($self_id)
    {
        $this->self_id = $self_id;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @param mixed $group_id
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;
    }

    /**
     * @param mixed $card
     */
    public function setCard($card)
    {
        $this->card = $card;
    }

    /**
     * @param mixed $message_id
     */
    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;
    }
    /**
     * @param $url
     * @param array $paras
     * @return array|bool|mixed|string
     * CURL访问
     */
    public function curl($url, array $paras = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if (isset($paras['Header'])) {
            $Header = $paras['Header'];
        } else {
            $Header[] = "Accept:*/*";
            $Header[] = "Accept-Encoding:gzip,deflate,sdch";
            $Header[] = "Accept-Language:zh-CN,zh;q=0.8";
            $Header[] = "Connection:close";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
        if (isset($paras['ctime'])) { // 连接超时
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $paras['ctime']);
        } else {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        }
        if (isset($paras['rtime'])) { // 读取超时
            curl_setopt($ch, CURLOPT_TIMEOUT, $paras['rtime']);
        }
        if (isset($paras['post'])) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
        }
        if (isset($paras['header'])) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if (isset($paras['cookie'])) {
            curl_setopt($ch, CURLOPT_COOKIE, $paras['cookie']);
        }
        if (isset($paras['refer'])) {
            if ($paras['refer'] == 1) {
                curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
            } else {
                curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
            }
        }
        if (isset($paras['ua'])) {
            curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
        }
        if (isset($paras['nobody'])) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (isset($paras['GetCookie'])) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            $result = curl_exec($ch);
            preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($result, 0, $headerSize); //状态码
            $body = substr($result, $headerSize);
            $ret = [
                "Cookie" => $matches, "body" => $body, "header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
            ];
            curl_close($ch);
            return $ret;
        }
        $ret = curl_exec($ch);
        if (isset($paras['loadurl'])) {
            $Headers = curl_getinfo($ch);
            if (isset($Headers['redirect_url'])) {
                $ret = $Headers['redirect_url'];
            } else {
                $ret = false;
            }
        }
        curl_close($ch);
        return $ret;
    }

    // 发送私信
    public function sendPrivateMsg($userId, $message)
    {
        $message=array(
            "user_id"=>$userId,
            "message"=>$message
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/send_private_msg", [
            'post' =>json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    // 发送群组消息
    public function sendGroupMsg($groupId, $message)
    {
        $message=array(
            "group_id"=>$groupId,
            "message"=>$message
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/send_group_msg", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    // 撤回群组消息
    public function deleteMsg($messageId)
    {
        $message=array(
            "message_id"=>$messageId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/delete_msg", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取消息信息
    public function getMassageInfo($messageId)
    {
        $message=array(
            "message_id"=>$messageId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_msg", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }


    //获取图片信息
    public function getImgInfo($imgName){
        $message=array(
            "file"=>$imgName
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_image", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //群组踢人
    public function kickGroupUser($groupId,$userId,$rejectAddRequest){
        $message=array(
            "group_id"=>$groupId,
            "user_id"=>$userId,
            "reject_add_request"=>$rejectAddRequest,
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_kick", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //群组禁言
    public function banGroupUser($groupId,$userId,$banTime){
        $message=array(
            "group_id"=>$groupId,
            "user_id"=>$userId,
            "duration"=>$banTime,
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_ban", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //群组匿名用户禁言
    public function banAnonymousUser($groupId,$userId,$userFlag,$banTime){
        $message=array(
            "group_id"=>$groupId,
            "user_id"=>$userId,
            "flag"=>$userFlag,
            "duration"=>$banTime,
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_anonymous_ban", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //群组全员禁言
    public function setWholeBan($groupId,$enable){
        $message=array(
            "group_id"=>$groupId,
            "enable"=>$enable
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_whole_ban", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //设置群管理员
    public function setGroupAdmin($groupId,$userId,$enable){
        $message=array(
            "group_id"=>$groupId,
            "user_id"=>$userId,
            "enable"=>$enable
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_admin", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //设置群名片
    public function setUserCard($groupId,$userId,$card){
        $message=array(
            "group_id"=>$groupId,
            "user_id"=>$userId,
            "card"=>$card
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_card", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //设置群名称
    public function setGroupName($groupId,$groupName){
        $message=array(
            "group_id"=>$groupId,
            "group_name"=>$groupName
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_name", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //离开群组
    public function leaveGroup($groupId,$isDismiss){
        $message=array(
            "group_id"=>$groupId,
            "is_dismiss"=>$isDismiss
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_leave", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //设置群头衔
    public function setSpecialTitle($groupId,$userId,$specialTitle,$duration){
        $message=array(
            "group_id"=>$groupId,
            "user_id"=>$userId,
            "special_title"=>$specialTitle,
            "duration"=>$duration
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_special_title", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //处理加好友请求
    public function setFriendAddRequest($flag,$approve,$remark){
        $message=array(
            "flag"=>$flag,
            "approve"=>$approve,
            "remark"=>$remark
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_friend_add_request", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //处理加群请求
    public function setGroupAddRequest($flag,$type,$approve,$reason){
        $message=array(
            "flag"=>$flag,
            "type"=>$type,
            "approve"=>$approve,
            "reason"=>$reason
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_add_request", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取账号信息
    public function getLoginInfo(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_login_info", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取企点账号信息
    public function getQidianLoginInfo(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/qidian_get_account_info", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取陌生人信息
    public function getStrangerInfo($userId,$noCache){
        $message=array(
            "user_id"=>$userId,
            "no_cache"=>$noCache
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_stranger_info", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取好友列表
    public function getFriendList(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_friend_list", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //删除好友
    public function deleteFriend($userId){
        $message=array(
            "user_id"=>$userId,
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/delete_friend", [
            'post' => $message,
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取群信息
    public function getGroupInfo($groupId,$noCache){
        $message=array(
            "group_id"=>$groupId,
            "no_cache"=>$noCache
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_info", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取群列表
    public function getGroupList(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_list", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取群成员列表
    public function getGroupMemberList($groupId){
        $message=array(
            "group_id"=>$groupId,
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_member_list", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取群成员列表
    public function getGroupHonorInfo($groupId,$getType){
        $message=array(
            "group_id"=>$groupId,
            "type"=>$getType,
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_honor_info", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //检查是否可以发送图片
    public function canSendImg(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/can_send_image", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //检查是否可以发送语音
    public function canSendRecord(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/can_send_record", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取版本信息
    public function getVersionInfo(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_version_info", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //重启go-cqhttp
    public function restartBot(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_restart", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //清理缓存
    public function cleanCache(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/clean_cache", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //设置群头像
    public function setGroupPortrait($groupId,$filePath,$Cache){
        $message=array(
            "group_id"=>$groupId,
            "file"=>$filePath,
            "cache"=>$Cache
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_group_portrait", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //中文分词
    public function getWordSlices($content){
        if(self::$SAFE_MODE!=true){
            $message=array(
                "content"=>$content
            );
            @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/.get_word_slices", [
                'post' => json_encode($message),
                'Header' => ["Content-Type: application/json"]
            ]);
            return $result;
        }else{
            return null;
        }
    }

    //图片OCR
    public function ocrImg($image){
        if(self::$SAFE_MODE!=true){
            $message=array(
                "image"=>$image
            );
            @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/.ocr_image", [
                'post' => json_encode($message),
                'Header' => ["Content-Type: application/json"]
            ]);
            return $result;
        }else{
            return null;
        }
    }

    //对事件执行快速操作
    public function handleQuickOperation($context,$operation){
        if(self::$SAFE_MODE!=true){
            $message=array(
                "context"=>$context,
                "operation"=>$operation
            );
            @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/.handle_quick_operation", [
                'post' => json_encode($message),
                'Header' => ["Content-Type: application/json"]
            ]);
            return $result;
        }else{
            return null;
        }
    }

    //获取群系统消息
    public function getGroupSystemMsg(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_system_msg", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取会员信息(暂不可用
    public function getVipInfo($userId){
        $message=array(
            "user_id"=>$userId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/_get_vip_info", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //上传群文件
    public function uploadGroupFile($groupId,$filePath,$fileName,$dirId){
        $message=array(
            "group_id"=>$groupId,
            "file"=>$filePath,
            "name"=>$fileName,
            "folder"=>$dirId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/upload_group_file", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取群文件系统信息
    public function getGroupFileInfo($groupId){
        $message=array(
            "group_id"=>$groupId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_file_system_info", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //或去取文件目录列表
    public function getGroupFileList($groupId){
        $message=array(
            "group_id"=>$groupId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_root_files", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取群子目录文件列表
    public function getGroupFolderList($groupId,$folderId){
        $message=array(
            "group_id"=>$groupId,
            "folder_id"=>$folderId,
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_files_by_folder", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取群文件资源链接
    public function getGroupFileUrl($groupId,$fileId,$fileType){
        $message=array(
            "group_id"=>$groupId,
            "file_id"=>$fileId,
            "busid"=>$fileType
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_file_url", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取状态
    public function getStatus(){
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_status", [
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取@all剩余次数
    public function getGroupAtAllRemain($groupId){
        $message=array(
            "group_id"=>$groupId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_at_all_remain", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //发送群公告
    public function sendGroupNotice($groupId,$content,$image){
        $message=array(
            "group_id"=>$groupId,
            "content"=>$content,
            "image"=>$image
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/_send_group_notice", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //重载事件过滤器
    public function reloadEventFilter($file){
        $message=array(
            "file"=>$file
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/reload_event_filter", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //下载文件
    public function downloadFile($url,$threadCount,$headers){
        $message=array(
            "url"=>$url,
            "thread_count"=>$threadCount,
            "headers"=>$headers
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/download_file", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取当前账号在线客户端
    public function getOnlineClients($noCache){
        $message=array(
            "no_cache"=>$noCache
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_online_clients", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取群历史消息
    public function getGroupHistoryMsg($messageSeq,$groupId){
        $message=array(
            "message_seq"=>$messageSeq,
            "group_id"=>$groupId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_group_msg_history", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //设置精华消息
    public function setEssenceMsg($messageId){
        $message=array(
            "message_id"=>$messageId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/set_essence_msg", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //删除精华消息
    public function deleteEssenceMsg($messageId){
        $message=array(
            "message_id"=>$messageId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/delete_essence_msg", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //删除精华消息
    public function getEssenceMsgList($groupId){
        $message=array(
            "group_id"=>$groupId
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/get_essence_msg_list", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //检查连接安全性(接口不可用
    public function checkUrlSafely($url){
        $message=array(
            "url"=>$url
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/check_url_safely", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取机型
    public function getModelShow($model){
        $message=array(
            "model"=>$model
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/_get_model_show", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //获取机型
    public function setModelShow($model,$modelShow){
        $message=array(
            "model"=>$model,
            "model_show"=>$modelShow
        );
        @$result=$this->curl("http://" . self::$HOST . ":" . self::$PORT . "/_set_model_show", [
            'post' => json_encode($message),
            'Header' => ["Content-Type: application/json"]
        ]);
        return $result;
    }

    //格式化输出返回值
    public static function varDumpToString($var) {
        ob_start();
        var_dump($var);
        return ob_get_clean();
    }

}
