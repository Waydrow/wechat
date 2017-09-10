<?php
/**
 * Created by PhpStorm.
 * User: Waydrow
 * Date: 2017/9/9
 * Time: 19:16
 */

include('wechatCallBack.php');

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
    <p>宠物详情</p>
</div>

<?php

    $pet_id = $_GET['pet_id'];
    $openid = $_GET['openid'];
//    echo 'from http: '.$_GET['openid'].'\n';
//    echo 'from session: '.$_SESSION['openid'];
    $wechatObj = new wechatCallbackapiTest();
    $url = "https://localhost/Pets/Interface/index.php/Home/Index/appGetPetById?pet_id=$pet_id";
    $data = $wechatObj->https_request($url);
    $dataArray = json_decode($data, true);
    echo '<div class="pet-img">'.
        '<img src="https://qcloud.waydrow.com'.$dataArray[0]["img"].'" width="200px" height="200px" style="display:block;margin:0 auto;" class="img-circle" alt="圆形图片">'.
        '</div>
        <div class="pet-info">'.
            '<p>名字：'.$dataArray[0]["petname"].'</p>
            <p>年龄：'.$dataArray[0]["age"].'</p>
            <p>种类：'.$dataArray[0]["breed"].'</p>
            <p>性别：'.$dataArray[0]["sex"].'</p>
            <p>性格：'.$dataArray[0]["character"].'</p>
        </div>'.
        '<input type="hidden" id="openid" name="openid" value="'.$openid.'" >'.
        '<input type="hidden" id="petid" name="petid" value="'.$pet_id.'" >';
?>
<button class="btn btn-block btn-primary btn-lg get-pet-btn" type="button">立即领养</button>

<script src="js/jquery-v1.10.2.min.js"></script>
<script src="js/zui.min.js"></script>
<script>
    $('.get-pet-btn').on('click', function() {
        var openid = $('#openid').val();
        var petid = $('#petid').val();
        var url = 'https://qcloud.waydrow.com/Pets/Interface/index.php/Home/Index/appDealApplicationFromWechat?username='+openid
            +'&pet_id='+petid;
        //alert(url);
        $.ajax({
            url: url,
            method: 'GET'
        }).success(function(data) {
            if (data == "-1") {
                alert("您已申请领养该宠物");
            } else if (data == "-2") {
                alert("同一用户不能同时领养超过3只宠物");
            } else if (data == "-3") {
                alert("同一用户不能同时申请超过5只宠物")
            } else if (data == "1") {
                alert("申请成功, 等待审核");
            }
        }).fail(function() {
            alert("申请失败，请稍后重试");
        });
    });
</script>
</body>
</html>
