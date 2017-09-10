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
                                                                        class="nav-header"
                                                                        data-toggle="collapse"><i
                class="fa fa-fw fa-fighter-jet"></i>宠物管理<i class="fa fa-collapse"></i></a></li>
        <li>
            <ul class="premium-menu nav nav-list collapse in">
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

        
        
<table class="table" style="width: 800px">
  <thead>
    <tr>
      <th>#</th>
      <th>用户名</th>
      <th>帐号</th>
      <th>权限</th>
      <th style="width: 3.5em;"></th>
    </tr>
  </thead>
  <tbody>
       <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
        <td><?php echo ($i); ?></td>
        <td><?php echo ($vo["adminname"]); ?></td>
        <td><?php echo ($vo["adminaccount"]); ?></td>
        <td>1</td>
          <td>
      <a href="<?php echo U("Home/Index/admin?id=$vo[id]");?>"><i class="fa fa-pencil"></i></a>
          </td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>
</table>
        


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