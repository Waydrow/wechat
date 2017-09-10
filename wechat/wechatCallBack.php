<?php
/**
 * Created by PhpStorm.
 * User: Waydrow
 * Date: 2017/9/9
 * Time: 16:42
 */

class wechatCallbackapiTest
{
    public $appid = "wxcd352815539c9fce";
    public $appsecret = "4facbdb58198ec95f46f41ed5df366cd";

    //验证签名
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            echo $echoStr;
            exit;
        }
    }

    //响应消息
    public function responseMsg()
    {

        //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"]; // php.ini 配置失败
        $postStr = file_get_contents('php://input');
        //$this->logger("R \r\n".$postStr);

        if (!empty($postStr)) {
            $this->logger("R \r\n" . $postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            //消息类型分离
            switch ($RX_TYPE) {
                case "event":
                    $result = $this->receiveEvent($postObj);//关注后直接推送的信息
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                case "shortvideo":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: " . $RX_TYPE;
                    break;
            }
            $this->logger("T \r\n" . $result);
            echo $result;
        } else {
            echo "";
            exit;
        }
    }

    //接收事件消息

    public function logger($log_content)
    {
        $max_size = 1000000;
        $log_filename = "log.xml";
        //if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
        file_put_contents($log_filename, date('Y-m-d H:i:s') . " " . $log_content . "\r\n", FILE_APPEND);
    }

    //接收文本消息

    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event) {
            case "subscribe":
                $content = "您好，欢迎来到 Hello Pets 宠物之家，快来领养一个宠物吧！";
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "CLICK":
                switch ($object->EventKey) {
                    case "get_pet":
                        $content = array();
                        $content[] = array("Title" => "宠物列表", "Description" => "", "PicUrl" => "https://qcloud.waydrow.com/wechat/img/dog1.jpg", "Url" => "https://qcloud.waydrow.com/wechat/pets_list.php?openid=$object->FromUserName");
                        break;
                    case "my_pet":
                        $content = array();
                        $content[] = array("Title" => "我的宠物", "Description" => "", "PicUrl" => "https://qcloud.waydrow.com/wechat/img/dog2.jpg", "Url" => "https://qcloud.waydrow.com/wechat/my_pets.php?openid=$object->FromUserName");
                        break;
                    default:
                        $content = "点击菜单：" . $object->EventKey;
                        break;
                }
                break;
            case "VIEW":
                $content = "跳转链接 " . $object->EventKey;
                break;
            case "SCAN":
                $content = "扫描场景 " . $object->EventKey;
                break;
            case "LOCATION":
                $content = "上传位置：纬度 " . $object->Latitude . ";经度 " . $object->Longitude;
                break;
            case "scancode_waitmsg":
                if ($object->ScanCodeInfo->ScanType == "qrcode") {
                    $content = "扫码带提示：类型 二维码 结果：" . $object->ScanCodeInfo->ScanResult;
                } else if ($object->ScanCodeInfo->ScanType == "barcode") {
                    $codeinfo = explode(",", strval($object->ScanCodeInfo->ScanResult));
                    $codeValue = $codeinfo[1];
                    $content = "扫码带提示：类型 条形码 结果：" . $codeValue;
                } else {
                    $content = "扫码带提示：类型 " . $object->ScanCodeInfo->ScanType . " 结果：" . $object->ScanCodeInfo->ScanResult;
                }
                break;
            case "scancode_push":
                $content = "扫码推事件";
                break;
            case "pic_sysphoto":
                $content = "系统拍照";
                break;
            case "pic_weixin":
                $content = "相册发图：数量 " . $object->SendPicsInfo->Count;
                break;
            case "pic_photo_or_album":
                $content = "拍照或者相册：数量 " . $object->SendPicsInfo->Count;
                break;
            case "location_select":
                $content = "发送位置：标签 " . $object->SendLocationInfo->Label;
                break;
            default:
                $content = "receive a new event: " . $object->Event;
                break;
        }

        if (is_array($content)) {
            $result = $this->transmitNews($object, $content);
        } else {
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收图片消息

    function bytes_to_emoji($cp)
    {
        if ($cp > 0x10000) {       # 4 bytes
            return chr(0xF0 | (($cp & 0x1C0000) >> 18)) . chr(0x80 | (($cp & 0x3F000) >> 12)) . chr(0x80 | (($cp & 0xFC0) >> 6)) . chr(0x80 | ($cp & 0x3F));
        } else if ($cp > 0x800) {   # 3 bytes
            return chr(0xE0 | (($cp & 0xF000) >> 12)) . chr(0x80 | (($cp & 0xFC0) >> 6)) . chr(0x80 | ($cp & 0x3F));
        } else if ($cp > 0x80) {    # 2 bytes
            return chr(0xC0 | (($cp & 0x7C0) >> 6)) . chr(0x80 | ($cp & 0x3F));
        } else {                    # 1 byte
            return chr($cp);
        }
    }

    //接收位置消息

    private function transmitNews($object, $newsArray)
    {
        if (!is_array($newsArray)) {
            return "";
        }
        $itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($newsArray as $item) {
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
$item_str    </Articles>
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //接收语音消息

    private function transmitText($object, $content)
    {
        if (!isset($content) || empty($content)) {
            return "";
        }

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

        return $result;
    }

    //接收视频消息

    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        //多客服人工回复模式
        if (strstr($keyword, "请问在吗") || strstr($keyword, "在线客服")) {
            $result = $this->transmitService($object);
            return $result;
        }

        //自动回复模式
        if (strstr($keyword, "文本")) {
            $content = "这是个文本消息";
        } else if (strstr($keyword, "表情")) {
            $content = "微笑：/::)\n乒乓：/:oo\n中国：" . $this->bytes_to_emoji(0x1F1E8) . $this->bytes_to_emoji(0x1F1F3) . "\n仙人掌：" . $this->bytes_to_emoji(0x1F335);
        } else if (strstr($keyword, "单图文")) {
            $content = array();
            $content[] = array("Title" => "单图文标题", "Description" => "单图文内容", "PicUrl" => "http://115.28.217.112/github/1.JPG", "Url" => "http://lvze1992.github.io/");
        } else if (strstr($keyword, "图文") || strstr($keyword, "多图文")) {
            $content = array();
            $content[] = array("Title" => "多图文1标题", "Description" => "", "PicUrl" => "http://115.28.217.112/github/2.JPG", "Url" => "http://lvze1992.github.io/");
            $content[] = array("Title" => "多图文2标题", "Description" => "", "PicUrl" => "http://115.28.217.112/github/3.JPG", "Url" => "http://lvze1992.github.io/");
            $content[] = array("Title" => "多图文3标题", "Description" => "", "PicUrl" => "http://115.28.217.112/github/4.JPG", "Url" => "http://lvze1992.github.io/");
        } else if (strstr($keyword, "音乐")) {
            $content = array();
            $content = array("Title" => "Love Me For Me", "Description" => "歌手：Savio Rego", "MusicUrl" => "http://115.28.217.112/github/Love_Me_For_Me.mp3", "HQMusicUrl" => "http://115.28.217.112/github/Love_Me_For_Me.mp3");
        } else {
            $content = date("Y-m-d H:i:s", time()) . "\n\n" . '<a href="http://lvze1992.github.io/">http://lvze1992.github.io/</a>' . "\n 发送照片，可进行人脸识别" . $this->bytes_to_emoji(0xD83D) . $this->bytes_to_emoji(0xDC36);
        }

        if (is_array($content)) {
            if (isset($content[0])) {
                $result = $this->transmitNews($object, $content);
            } else if (isset($content['MusicUrl'])) {
                $result = $this->transmitMusic($object, $content);
            }
        } else {
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收链接消息

    private function transmitService($object)
    {
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复文本消息

    private function transmitMusic($object, $musicArray)
    {
        if (!is_array($musicArray)) {
            return "";
        }
        $itemTpl = "<Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
    </Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[music]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图文消息

    private function receiveImage($object)
    {
        $content = array("MediaId" => $object->MediaId);
        $result = $this->transmitImage($object, $content);
        return $result;
    }

    //回复音乐消息

    private function transmitImage($object, $imageArray)
    {
        include_once 'index2.php';

        if ($recog_info[0] == 1) {
            $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
            $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $recog_info[1]);

            return $result;
        } else {

            $itemTpl = "<Image>
        <MediaId><![CDATA[%s]]></MediaId>
    </Image>";

            $item_str = sprintf($itemTpl, $imageArray['MediaId']);

            $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    $item_str
</xml>";

            $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
            return $result;
        }
    }

    //回复图片消息

    private function receiveLocation($object)
    {
        $content = "你发送的是位置，经度为：" . $object->Location_Y . "；纬度为：" . $object->Location_X . "；缩放级别为：" . $object->Scale . "；位置为：" . $object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复语音消息

    private function receiveVoice($object)
    {
        if (isset($object->Recognition) && !empty($object->Recognition)) {
            $content = "你刚才说的是：" . $object->Recognition;
            $result = $this->transmitText($object, $content);
        } else {
            $content = array("MediaId" => $object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }
        return $result;
    }

    //回复视频消息

    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
        <MediaId><![CDATA[%s]]></MediaId>
    </Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[voice]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息

    private function receiveVideo($object)
    {
        $content = "上传视频类型：" . $object->MsgType;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复第三方接口消息

    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：" . $object->Title . "；内容为：" . $object->Description . "；链接地址为：" . $object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //字节转Emoji表情

    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
        <MediaId><![CDATA[%s]]></MediaId>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
    </Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[video]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //日志记录

    private function relayPart3($url, $rawData)
    {
        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function https_request($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}