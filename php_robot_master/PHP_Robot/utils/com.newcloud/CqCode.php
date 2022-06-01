<?php
/*
 * Copyright (c) 2022. New Cloud | Pomelo
 * Email: <2284186613@qq.com>.
 * ProjectName:<New Cloud | PHP_Robot>
 * Developer:["Pomelo","LoYin"];
 */

class CqCode
{
//    根据QQ@用户
    static function atUser($userId): string
    {
        return "[CQ:at,qq={$userId}]";
    }

//    发送QQ表情
    static function qqFace($faceId): string
    {
        return "[CQ:face,id={$faceId}]";
    }

//    发送QQ语音
    static function sendVoice($voicePath): string
    {
        return "[CQ:record,file={$voicePath}]";
    }

//    分享QQ链接
    static function sharaLink($linkUrl, $linkTitle): string
    {
        return "[CQ:share,url={$linkUrl},title={$linkTitle}]";
    }

//    分享音乐
    static function sharaMusic($musicType, $musicId): string
    {
        return "[CQ:music,type={$musicType},id={$musicId}]";
    }

//      自定义分享音乐
    static function customSharaMusic($musicUrl, $musicAudio, $musicTitle): string
    {
        return "[CQ:music,type=custom,url={$musicUrl},audio={$musicAudio},title={$musicTitle}]";
    }

    //待更点：支持更多的图片类型
//    发送普通发图
    static function sendCommonImg($imgPath): string
    {
        return "[CQ:image,file={$imgPath},id=40000]";
    }

//    发送闪照
    static function sendFlashImg($imgPath): string
    {
        return "[CQ:image,file={$imgPath},id=40000,type=flash]";
    }

//    发送秀图
    static function sendShowImg($imgPath): string
    {
        return "[CQ:image,file={$imgPath},id=40000,type=show]";
    }

//    发送戳一戳
    static function sendPokeMessage($userQq): string
    {
        return "[CQ:poke,qq={$userQq}]";
    }

//    发送xml消息
    static function sendXmlMessage($xmlData): string
    {
        return "[CQ:xml,data={$xmlData}]";
    }

//    发送卡片图消息
    static function sendCardImgMessage($imgPath): string
    {
        return "[CQ:cardimage,file={$imgPath}]";
    }

//    文字转为语音发送
    static function textToVoice($textContent):string
    {
        return "[CQ:tts,text={$textContent}]";
    }

}