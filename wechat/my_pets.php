<?php
/**
 * Created by PhpStorm.
 * User: Waydrow
 * Date: 2017/9/10
 * Time: 10:54
 */

include('wechatCallBack.php');
$wechatObj = new wechatCallbackapiTest();

// 判断是否已绑定
$openid = $_GET['openid'];
$_SESSION['openid'] = $_GET['openid'];
// 查看用户是否已绑定
$turl = "https://localhost/Pets/Interface/index.php/Home/Index/findUserByUserName?username=$openid";
$output = $wechatObj->https_request($turl);
if ($output=="null") {
    echo '<script>alert("请先绑定");window.close();</script>';
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
    <p>我的宠物</p>
</div>


<div class="items">
<?php

    $openid = $_GET['openid'];
    $wechatObj = new wechatCallbackapiTest();
    $url = "https://localhost/Pets/Interface/index.php/Home/Index/appGetWaitingFromWechat?username=$openid";
    $data = $wechatObj->https_request($url);
    $dataArray = json_decode($data, true);
    if (empty($dataArray)) {
        echo '<script>alert("您还没有宠物哦，快去领养一个吧！")</script>';
    } else {
        foreach ($dataArray as $item) {
            echo '<div class="item">'.
                '<div class="item-content">'.
                '<div class="media pull-left"><img src="https://qcloud.waydrow.com'.$item["img"].'" alt=""></div>'.
                '<div class="text">'.
                '<p style="font-size: 24px">宠物名字：'.$item["petname"].'</p>';
            if ($item["ispass"] == "1") {
                echo '<p style="font-size: 18px">申请状态：<span class="label label-success">申请成功</span></p>';
            } else if ($item["ispass"] == "0") {
                echo '<p style="font-size: 18px">申请状态：<span class="label label-warning">等待审核</span></p>';
            } else if ($item["ispass"] == "-1") {
                echo '<p style="font-size: 18px">申请状态：<span class="label label-danger">申请失败</span></p>';
            }
            echo
                '</div>'.
                '</div>'.
                '</div>';
        }
    }

?>

</div>
<!--<div class="items">-->
<!--    <div class="item">-->
<!--        <div class="item-content">-->
<!--            <div class="media pull-left"><img src="img/2.jpg" alt=""></div>-->
<!--            <div class="text">-->
<!--                <p style="font-size: 24px">宠物名字</p>-->
<!--                <p style="font-size: 18px">申请状态：<span class="label label-success">维基</span></p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="item">-->
<!--        <div class="item-content">-->
<!--            <div class="media pull-left"><img src="img/2.jpg" alt=""></div>-->
<!--            <div class="text">-->
<!--                <p style="font-size: 24px">宠物名字</p>-->
<!--                <p style="font-size: 18px">申请状态：<span class="label label-success">维基</span></p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

</body>
</html>
