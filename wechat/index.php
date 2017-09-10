<?php
header('Content-type:text');

include('wechatCallBack.php');
define("TOKEN", "waydrow");
$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
} else {
    $wechatObj->valid();
}

?>