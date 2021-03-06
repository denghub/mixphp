<?php

namespace apps\websocketd\controllers;

use mix\websocket\Controller;
use apps\websocketd\models\MessageForm;

/**
 * 消息控制器
 * @author 刘健 <coder.liu@qq.com>
 */
class MessageController extends Controller
{

    // 加入房间
    public function actionEmit($data, $userinfo)
    {
        // 使用模型
        $model             = new MessageForm();
        $model->attributes = $data;
        $model->setScenario('to');
        // 验证失败
        if (!$model->validate()) {
            return;
        }

        // 通过消息队列给指定用户id发消息
        \Mix::app()->redis->publish('emit_to_' . $model->uid, $model->message);
    }

}
