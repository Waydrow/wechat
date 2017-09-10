<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pets Admin</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="/Pets/Public/lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/Pets/Public/lib/font-awesome/css/font-awesome.css">

    <script src="/Pets/Public/lib/jquery-1.11.1.min.js" type="text/javascript"></script>

    <script src="/Pets/Public/lib/jQuery-Knob/js/jquery.knob.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $(".knob").knob();
        });
    </script>


    <link rel="stylesheet" type="text/css" href="/Pets/Public/stylesheets/theme.css">
    <link rel="stylesheet" type="text/css" href="/Pets/Public/stylesheets/premium.css">

</head>
<body class=" theme-blue">

<!-- Demo page code -->

<script type="text/javascript">
    $(function () {
        var match = document.cookie.match(new RegExp('color=([^;]+)'));
        if (match) var color = match[1];
        if (color) {
            $('body').removeClass(function (index, css) {
                return (css.match(/\btheme-\S+/g) || []).join(' ')
            })
            $('body').addClass('theme-' + color);
        }

        $('[data-popover="true"]').popover({html: true});

    });
</script>
<style type="text/css">
    #line-chart {
        height: 300px;
        width: 800px;
        margin: 0px auto;
        margin-top: 1em;
    }

    .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover {
        color: #fff;
    }
</style>

<script type="text/javascript">
    $(function () {
        var uls = $('.sidebar-nav > ul > *').clone();
        uls.addClass('visible-xs');
        $('#main-menu').append(uls.clone());
    });
</script>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="../assets/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">


<!--[if lt IE 7 ]>
<body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>
<body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]>
<body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]>
<body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->

<!--<![endif]-->

<div class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="" href="index.html"><span class="navbar-brand"><span class="fa fa-paper-plane"></span> Pets后台管理</span></a>
    </div>

    <div class="navbar-collapse collapse" style="height: 1px;">
        <ul id="main-menu" class="nav navbar-nav navbar-right">
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user padding-right-small"
                          style="position:relative;top: 3px;"></span> <?php echo ($name); ?>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo U('/Home/Index/order');?>">宠物</a></li>
                    <li><a href="<?php echo U('/Home/Index/users');?>">用户</a></li>
                    <li class="divider"></li>
                    <li><a tabindex="-1" href="<?php echo U('/Home/Index/login');?>">退出</a></li>
                </ul>
            </li>
        </ul>

    </div>
</div>
<div class="copyrights">Collect from <a href="http://www.cssmoban.com/" title="WEBSHOP">WEBSHOP</a></div>

<div class="sidebar-nav">
    <ul>
        <li><a href="#" data-target=".dashboard-menu" class="nav-header" data-toggle="collapse"><i
                class="fa fa-fw fa-dashboard"></i>Pets后台<i class="fa fa-collapse"></i></a></li>
        <li>
            <ul class="dashboard-menu nav nav-list collapse in">
                <li><a href="<?php echo U('/Home/Index/index');?>"><span class="fa fa-caret-right"></span>后台首页</a></li>
                <li><a href="<?php echo U('/Home/Index/apply');?>"><span class="fa fa-caret-right"></span>最新申请</a></li>
                <!--<li><a href="<?php echo U('/Home/Index/notice');?>"><span class="fa fa-caret-right"></span>公告管理</a></li>-->
            </ul>
        </li>
        <li data-popover="true" rel="popover" data-placement="right"><a href="#" data-target=".room-menu"
                                                                        class="nav-header collapsed"
                                                                        data-toggle="collapse"><i
                class="fa fa-fw fa-fighter-jet"></i>房间管理<i class="fa fa-collapse"></i></a></li>
        <li>
            <ul class="room-menu nav nav-list collapse">
                <li><a href="<?php echo U('/Home/Index/rooms');?>"><span class="fa fa-caret-right"></span>房间列表</a></li>
                <!--<li><a href="<?php echo U('/Home/Index/userselect');?>"><span class="fa fa-caret-right"></span>用户检索</a></li>-->
            </ul>
        </li>
        <li data-popover="true" rel="popover" data-placement="right"><a href="#" data-target=".premium-menu"
                                                                        class="nav-header collapsed"
                                                                        data-toggle="collapse"><i
                class="fa fa-fw fa-fighter-jet"></i>宠物管理<i class="fa fa-collapse"></i></a></li>
        <li>
            <ul class="premium-menu nav nav-list collapse">
                <li class="visible-xs visible-sm"><a href="#">- Premium features require a license -</a>
                <li><a href="<?php echo U('/Home/Index/petslist');?>"><span class="fa fa-caret-right"></span>宠物列表</a></li>
                <li><a href="<?php echo U('/Home/Index/lookafter');?>"><span class="fa fa-caret-right"></span>照料列表</a></li>
                <li><a href="<?php echo U('/Home/Index/petsUser');?>"><span class="fa fa-caret-right"></span>领养记录</a></li>
            </ul>
        </li>

        <li><a href="#" data-target=".accounts-menu" class="nav-header collapsed" data-toggle="collapse"><i
                class="fa fa-fw fa-briefcase"></i>护工管理<span class="label label-info">+3</span></a></li>
        <li>
            <ul class="accounts-menu nav nav-list collapse">
                <li><a href="<?php echo U('/Home/Index/careworkers');?>"><span class="fa fa-caret-right"></span>护工列表</a></li>
            </ul>
        </li>

        <li><a href="#" data-target=".user-menu" class="nav-header collapsed" data-toggle="collapse"><i
                class="fa fa-fw fa-legal"></i>用户管理<i class="fa fa-collapse"></i></a></li>
        <li>
            <ul class="user-menu nav nav-list collapse">
                <li><a href="<?php echo U('/Home/Index/users');?>"><span class="fa fa-caret-right"></span>用户列表</a></li>
                <li><a href="<?php echo U('/Home/Index/apply');?>"><span class="fa fa-caret-right"></span>申请列表</a></li>
            </ul>
        </li>

        <li><a href="#" data-target=".legal-menu" class="nav-header collapsed" data-toggle="collapse"><i
                class="fa fa-fw fa-legal"></i>管理员管理<i class="fa fa-collapse"></i></a></li>
        <li>
            <ul class="legal-menu nav nav-list collapse">
                <li><a href="<?php echo U('/Home/Index/admins');?>"><span class="fa fa-caret-right"></span>管理员列表</a></li>
                <li><a href="<?php echo U('/Home/Index/addadmin');?>"><span class="fa fa-caret-right"></span>新增管理员</a></li>
            </ul>
        </li>

        <li><a href="#" class="nav-header"><i class="fa fa-fw fa-question-circle"></i>帮助</a></li>
    </ul>
</div>


<div class="content">
    <div class="main-content">

        
        <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>商品修改</title>
    <!--<link rel="stylesheet" type="text/css" href="/Pets/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" />
    <script type="text/javascript" src="/Pets/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
    <script type="text/javascript" src="/Pets/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
    <script type="text/javascript" src="/Pets/Public/umeditor1_2_2-utf8-php/umeditor.js"></script>
    <script type="text/javascript" src="/Pets/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>-->
        <script type="text/javascript" src="/Pets/Public/utf8-php/ueditor.config.js"></script>
        <script type="text/javascript" src="/Pets/Public/utf8-php/ueditor.all.min.js"></script>
    <script type="text/javascript" src="/Pets/Public/utf8-php/lang/zh-cn/zh-cn.js"></script>
    <link rel="stylesheet" href="/Pets/Public/css/jquery.fileupload.css">
    <link rel="stylesheet" href="/Pets/Public/css/jquery.fileupload-ui.css">
    <script src="/Pets/Public/js/jquery.min.js"></script>
    <script src="/Pets/Public/js/vendor/jquery.ui.widget.js"></script>
    <script src="/Pets/Public/js/jquery.fileupload.js"></script>
    <script src="/Pets/Public/js/jquery.iframe-transport.js"></script>
        <!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="/Pets/Public/webuploader-0.1.5/webuploader.css">
    <!--引入JS-->
    <script type="text/javascript" src="/Pets/Public/webuploader-0.1.5/webuploader.js"></script>
</head>

<body class=" theme-blue">
    <!-- Demo page code -->
    <script type="text/javascript">
    $(function() {
        var match = document.cookie.match(new RegExp('color=([^;]+)'));
        if (match) var color = match[1];
        if (color) {
            $('body').removeClass(function(index, css) {
                return (css.match(/\btheme-\S+/g) || []).join(' ')
            })
            $('body').addClass('theme-' + color);
        }

        $('[data-popover="true"]').popover({
            html: true
        });

    });
    </script>
    <style type="text/css">
    #line-chart {
        height: 300px;
        width: 800px;
        margin: 0px auto;
        margin-top: 1em;
    }
    
    .navbar-default .navbar-brand,
    .navbar-default .navbar-brand:hover {
        color: #fff;
    }
    </style>
    <script type="text/javascript">
    $(function() {
        var uls = $('.sidebar-nav > ul > *').clone();
        uls.addClass('visible-xs');
        $('#main-menu').append(uls.clone());
    });
    </script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
    <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
    <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
    <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!-->
    <!--<![endif]-->
    <div class="header">
        <h1 class="page-title">商品</h1>
        <ul class="breadcrumb">
            <li><a href="<?php echo U("Home/Index/");?>">主页</a> </li>
            <li><a href="<?php echo U("Home/Index/goodslist");?>">商品管理</a> </li>
            <li class="active">商品添加</li>
        </ul>
    </div>
    <div class="main-content">
        <form id="form1" action="" enctype="multipart/form-data" method="post">
            <input type="hidden" id="goodsid" value="<?php echo ($goodsid); ?>" />
            <div class="row">
                <div class="col-md-4">
                    <br>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="home">
                            <div class="form-group">
                                <label>商品图片</label>
                                <br>
                                <img src="" id="firstphopo">
                                <div id="fileList" class="uploader-list"></div>
                                <div id="filePicker">选择图片</div>
                                <input type="hidden" id="temp" name="pp" />
                            </div>
                            <div class="form-group">
                                <label>商品名</label>
                                <input type="text" id="goodsname" name="goodsname" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>商品价格</label>
                                <input type="text" id="goodsprice" name="goodsprice" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>商品分类</label>
                                <select name="goodsclassify" id="goodsclassify" class="form-control">
                                    <?php if(is_array($classify)): $i = 0; $__LIST__ = $classify;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mode2): $mod = ($i % 2 );++$i;?><option value="<?php echo ($mode2["id"]); ?>"><?php echo ($mode2["classifyname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>商品介绍</label>
                                <textarea name="detail" id="myEditor" style="width:1000px;height:480px;" value=""></textarea>
                                <script type="text/javascript">
                                //实例化编辑器
                                var um = UE.getEditor('myEditor');
                                editor.render("myEditor");
                                </script>
                            </div>
                            <div class="btn-toolbar list-toolbar">
                                <button class="btn btn-primary" id="save" name="save"><i class="fa fa-save"></i> 保存</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal small fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">删除确认</h3>
                        </div>
                        <div class="modal-body">
                            <p class="error-text"><i class="fa fa-warning modal-icon"></i>确定要删除这个商品？</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">取消</button>
                            <button class="btn btn-danger" name="delete" onclick="form1.action='/Pets/index.php/Home/Index/goodsadd';form1.submit();" data-dismiss="modal">删除</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script src="lib/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="/505/Public/js/jquery-v1.10.2.min.js"></script>
        <script type="text/javascript">
        $("#save").click(function() {
            var image = $('#image')[0].src;
            $("#temp").attr("value", image);
            $('#form1').submit();
        })
        </script>
        <script type="text/javascript">
        jQuery(function() {
            var $ = jQuery,
                $list = $('#fileList'),
                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,

                // 缩略图大小
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,

                // Web Uploader实例
                uploader;

            // 初始化Web Uploader
            uploader = WebUploader.create({

                // 自动上传。
                auto: true,

                // swf文件路径
                swf: '/Pets/Public/webuploader-0.1.5/Uploader.swf',

                // 文件接收服务端。
                server: '/Pets/Public/webuploader-0.1.5/fileupload.php',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 只允许选择文件，可选。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });

            // 当有文件添加进来的时候


            // 文件上传过程中创建进度条实时显示。
            uploader.on('uploadProgress', function(file, percentage) {
                var $li = $('#' + file.id),
                    $percent = $li.find('.progress span');

                // 避免重复创建
                if (!$percent.length) {
                    $percent = $('<p class="progress"><span></span></p>')
                        .appendTo($li)
                        .find('span');
                }

                $percent.css('width', percentage * 100 + '%');
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function(file, ret) {
                $('#' + file.id).addClass('upload-state-done');
                var url = ret.url;
                url = url.replace('\\', "/")
                $('#firstphopo').attr("src", "/Pets/Public/webuploader-0.1.5/" + url);
                $('#temp').attr('value', "/Pets/Public/webuploader-0.1.5/" + url);
            });

            // 文件上传失败，现实上传出错。
            uploader.on('uploadError', function(file) {
                var $li = $('#' + file.id),
                    $error = $li.find('div.error');

                // 避免重复创建
                if (!$error.length) {
                    $error = $('<div class="error"></div>').appendTo($li);
                }

                $error.text('上传失败');
            });

            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on('uploadComplete', function(file) {
                $('#' + file.id).find('.progress').remove();
            });
        });
        </script>
        <script type="text/javascript">
        updateGoods();
        $("#colorleft").on("click", function() {
            updateGoods();
        });
        $("#sizeleft").on("click", function() {
            updateGoods();
        });


        function updateGoods() {
            var name = $("#goodsname").val();
            var image = $('#image')[0].src;
            var price = $("#goodsprice").val();
            var classifyid = $("#goodsclassify").val();
            var detail = $('#myEditor').val();
            var data = {
                name: name,

                color: color
            };
            var leftNum = $("#leftnum");
            $.ajax({
                    url: '<?php echo U("Home/Index/goodsajax");?>',
                    type: 'POST',
                    data: data
                })
                .done(function(dataget) {
                    console.log("success");
                    console.log(dataget)
                    $(leftNum).attr('value', dataget);
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
        }
        </script>
        <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function() {
                return false;
            });
        });
        </script>
        <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function() {
                return false;
            });
        });
        </script>
</body>

</html>

        


    </div>
</div>


<script src="/Pets/Public/lib/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
    $(function () {
        $('.demo-cancel-click').click(function () {
            return false;
        });
    });
</script>


</body>
</html>