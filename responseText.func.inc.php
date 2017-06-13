<?php
	//回复消息
	function _response_text($object,$content){
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>%d</FuncFlag>
					</xml>";
		$resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
		return $resultStr;
	}

	//处理事件
	function handleEvent($object)    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "感谢您关注【小玉机器人】"."\n"."您可以直接输入以下指令来获取传感器状态或控制开关:".
				"\n"."    温度"."\n"."    开灯"."\n"."    关灯";
                break;
            default :
                $contentStr = "Unknow Event: ".$object->Event;
                break;
        }
		$resultStr = _response_text($object, $contentStr);        
        return $resultStr;
	}
	
?>