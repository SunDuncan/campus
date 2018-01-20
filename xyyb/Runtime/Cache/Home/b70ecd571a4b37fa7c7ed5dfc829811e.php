<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>html5shiv.js"></script>
    <script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>respond.min.js"></script>
    <script type="text/javascript" src="http://cdn.bootcss.com/css3pie/2.0beta1/PIE_IE678.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo (HUI_CSS_URL); ?>H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo (HUI_ADMIN_CSS_URL); ?>H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo (HUI_ADMIN_LIB); ?>Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo (HUI_ADMIN_SKIN_URL); ?>default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="<?php echo (HUI_ADMIN_CSS_URL); ?>css/style.css" />
    <link rel="stylesheet" href="<?php echo (HUI_ADMIN_LIB); ?>zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <!--[if IE 6]>
    <script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <!--[if IE 7]>
    <link href="http://www.bootcss.com/p/font-awesome/assets/css/font-awesome-ie7.min.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <meta name="keywords" content="校园佣兵">
    <meta name="description" content="校园佣兵">
    <title>添加字典</title>
</head>
<body>
<div class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-user-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">
                <span class="c-red">*</span>
                分类名称：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="" placeholder="" id="user-name" name="product-category-name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">
                <span class="c-red">*</span>
                字典代码：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="" placeholder="" id="user-name" name="product-category-name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">
                <span class="c-red">*</span>
                字典值：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="" placeholder="" id="user-name" name="product-category-name">
            </div>
        </div>
        <div class="row cl">
            <div class="col-9 col-offset-2">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>layer/2.4/layer.js"></script>
<script type="text/javascript" src="<?php echo (HUI_JS_URL); ?>H-ui.min.js"></script>
<script type="text/javascript" src="<?php echo (HUI_ADMIN_JS_URL); ?>H-ui.admin.js"></script>
<script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>Validform/5.3.2/Validform.js/Validform.min.js"></script>
<!--/_footer 作为公共模版分离出去-->
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function(){

    });
</script>
</body>
</html>