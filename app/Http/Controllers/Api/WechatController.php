<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WechatController extends Controller
{

    public function index()
    {
        $type = \Wechat::getRev()->getRevType(); // 获取数据类型
        $data = \Wechat::getRev()->getRevData(); // 获取微信服务器发来的信息

        switch ($type) {
            case app('wechat')::MSGTYPE_TEXT : // 文本类型
                // 记录文本消息到数据库

                //---特殊操作优先---

                // 关键字回复

                //自动回复

                break;
            case app('wechat')::MSGTYPE_EVENT : // 事件类型
                if ($data ['Event'] == "subscribe") { // 关注事件
                    //记录关注事件

                    //添加粉丝操作

                    //扫码关注操作

                    //关注回复

                } elseif ($data ['Event'] == "unsubscribe") { // 取消关注事件
                    //记录取消关注事件

                    //粉丝操作

                } elseif ($data ['Event'] == "LOCATION") { // 获取上报的地理位置事件
                    //记录用户自动上传的地址位置

                } elseif ($data ['Event'] == "CLICK") { // 自定义菜单
                    // 记录自定义菜单消息

                    //菜单点击事件
                    $event_key = $data ["EventKey"];

                } elseif ($data ['Event'] == "VIEW") { // 点击菜单跳转链接时的事件推送
                    // 记录自定义菜单消息

                } elseif ($data['Event'] == "SCAN") {   //扫二维码进入公众号
                    // 记录自定义菜单消息

                } elseif (!empty($data['KfAccount'])) {  //客服时间

                    /*$kefuSend = array(
                        "touser" => $data['FromUserName'],
                        "msgtype" => "text",
                    );

                    if ($data['Event'] == "kf_create_session") {    //接入会话
                        $kefuSend["text"]["content"] = "您好，您已接入到客服系统~再次点击可退出";
                    } elseif ($data['Event'] == "kf_close_session") {  //关闭会话
                        $kefuSend["text"]["content"] = "已退出客服系统~欢迎再次使用";
                    } elseif ($data['Event'] == "kf_switch_session") {    //转接会话
                        $kefuSend["text"]["content"] = "已转接客服~";
                    }

                    \Wechat::sendCustomMessage($kefuSend);*/
                }
                break;
            case app('wechat')::MSGTYPE_IMAGE : // 图片类型
                // 记录图片消息

                break;
            case app('wechat')::MSGTYPE_LOCATION : // 地理位置类型
                \Wechat::text("地理位置已接收")->reply();
                break;

            case app('wechat')::MSGTYPE_LINK : // 链接消息
                \Wechat::text("链接消息已接收")->reply();
                break;
            default :
                \Wechat::text("help info")->reply();
        }


    }

}
