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
    <title>产品分类</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品分类 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<table class="table">
    <tr>
        <td width="200" class="va-t"><ul id="treeDemo" class="ztree"></ul></td>
        <td class="va-t"><iframe ID="testIframe" Name="testIframe" FRAMEBORDER=0 SCROLLING=AUTO width=100%  height=390px SRC="product-category-add.html"></iframe></td>
    </tr>
</table>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>layer/2.4/layer.js"></script>
<script type="text/javascript" src="<?php echo (HUI_JS_URL); ?>H-ui.min.js"></script>
<script type="text/javascript" src="<?php echo (HUI_ADMIN_JS_URL); ?>H-ui.admin.js"></script>
<script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>Validform/5.3.2/Validform.js/Validform.min.js"></script>
<!--/_footer 作为公共模版分离出去-->
<script type="text/javascript" src="<?php echo (HUI_ADMIN_LIB); ?>zTree/v3/js/jquery.ztree.all-3.5.min.js"></script>
<script type="text/javascript">
    var setting = {
        view: {
            dblClickExpand: false,
            showLine: false,
            selectedMulti: false
        },
        data: {
            simpleData: {
                enable:true,
                idKey: "id",
                pIdKey: "pId",
                rootPId: ""
            }
        },
        callback: {
            beforeClick: function(treeId, treeNode) {
                var zTree = $.fn.zTree.getZTreeObj("tree");
                if (treeNode.isParent) {
                    zTree.expandNode(treeNode);
                    return false;
                } else {
                    demoIframe.attr("src",treeNode.file + ".html");
                    return true;
                }
            }
        }
    };

    var zNodes =[
        { id:1, pId:0, name:"一级分类", open:true},
        { id:11, pId:1, name:"二级分类"},
        { id:111, pId:11, name:"三级分类"},
        { id:112, pId:11, name:"三级分类"},
        { id:113, pId:11, name:"三级分类"},
        { id:114, pId:11, name:"三级分类"},
        { id:115, pId:11, name:"三级分类"},
        { id:12, pId:1, name:"二级分类 1-2"},
        { id:121, pId:12, name:"三级分类 1-2-1"},
        { id:122, pId:12, name:"三级分类 1-2-2"},
    ];

    var code;

    function showCode(str) {
        if (!code) code = $("#code");
        code.empty();
        code.append("<li>"+str+"</li>");
    }

    $(document).ready(function(){
        var t = $("#treeDemo");
        t = $.fn.zTree.init(t, setting, zNodes);
        demoIframe = $("#testIframe");
        //demoIframe.on("load", loadReady);
        var zTree = $.fn.zTree.getZTreeObj("tree");
        //zTree.selectNode(zTree.getNodeByParam("id",'11'));
    });
</script>
</body>
</html>