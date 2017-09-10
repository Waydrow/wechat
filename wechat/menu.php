<?php

$appid = "wxcd352815539c9fce";
$appsecret = "4facbdb58198ec95f46f41ed5df366cd";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$output = https_request($url);
$jsoninfo = json_decode($output, true);

$access_token = $jsoninfo["access_token"];

$jsonmenu = '{
      "button":[
      {

           "type": "view",
           "name":"点击绑定",
           "url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxcd352815539c9fce&redirect_uri=https://qcloud.waydrow.com/wechat/pets_list.php&response_type=code&scope=snsapi_userinfo#wechat_redirect"
       },
       {

           "type": "click",
           "name":"我要领养",
           "key": "get_pet"
       },
       {

           "type": "click",
           "name":"我的宠物",
           "key": "my_pet"
       },
       ]
 }';


$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
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

?>