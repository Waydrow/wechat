<?php
/**
 * Created by PhpStorm.
 * User: Waydrow
 * Date: 2017/9/9
 * Time: 14:51
 */
include('wechatCallBack.php');
$wechatObj = new wechatCallbackapiTest();
// get oauth code
// 从点击绑定进入
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $get_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$wechatObj->appid&secret=$wechatObj->appsecret&code=$code&grant_type=authorization_code";
// get access token
    $output = $wechatObj->https_request($get_token_url);
    $jsonData = json_decode($output, true);
    $access_token = $jsonData['access_token'];
    $openid = $jsonData['openid'];

// get user info
    $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
    $user_output = $wechatObj->https_request($get_user_info_url);
    $jsonUser = json_decode($user_output, true);

    // store in database
    $username = $jsonUser['openid'];
    $realname = $jsonUser['nickname'];
    $password = "222";
    $sex = "";
    if ($jsonUser['sex']==1) {
        $sex = "男";
    } else {
        $sex = "女";
    }
    $idcard = "x";
    $phone = "x";
    $address = 'x';
    $store_user_url= "https://localhost/Pets/Interface/index.php/Home/Index/appRegister".
        "?username=$username&realname=$realname&password=$password&sex=$sex&idcard=$idcard&phone=$phone&address=$address";
    $store_output = $wechatObj->https_request($store_user_url);

    // openid -> seesion
    $_SESSION['openid'] = $jsonUser['openid'];
}

// 从宠物列表打开
if (isset($_GET['openid'])) {
    $openid = $_GET['openid'];
    $_SESSION['openid'] = $_GET['openid'];
    // 查看用户是否已绑定
    $turl = "https://localhost/Pets/Interface/index.php/Home/Index/findUserByUserName?username=$openid";
    $output = $wechatObj->https_request($turl);
    if ($output=="null") {
        echo '<script>alert("请先绑定");window.close();</script>';
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = 0" />
    <title>Hello Pets</title>
    <link rel="stylesheet" href="css/zui.min.css">
    <link rel="stylesheet" href="css/zui-theme.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="head-tag">
    <p>宠物列表</p>
</div>

<div class="cards cards-condensed">
    <?php
    //include('wechatCallBack.php');
    $wechatObjj = new wechatCallbackapiTest();
    $url = "https://localhost/Pets/Interface/index.php/Home/Index/appGetPets";
    $data = $wechatObjj->https_request($url);
//    $wechatObjj->logger($data);
    $dataArray = json_decode($data, true);
    foreach ($dataArray as $item) {
        echo '<div class="col-xs-6">'.
            '<a class="card" href="https://qcloud.waydrow.com/wechat/pet_detail.php?pet_id='.$item["id"].'&openid='.$_SESSION["openid"].'">'.
            '<img src="https://qcloud.waydrow.com'.$item["img"].'" alt="">'.
            '<div class="card-heading"><strong>'.$item["petname"].'</strong></div>'.
            '</a>
            </div>';
    }
    ?>
</div>

<script src="js/jquery-v1.10.2.min.js"></script>
<script src="js/zui.min.js"></script>

</body>
</html>
