<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"E:\vhost\tpshop\public/../application/admin\view\goods\add.html";i:1551927068;}*/ ?>
﻿<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
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
<script type="text/javascript" src="/static/admin/lib/html5shiv.js"></script>
<script type="text/javascript" src="/static/admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/lib/webuploader/0.1.5/webuploader.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/static/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->

<title>基本设置</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
	<span class="c-gray en">&gt;</span>
	系统管理
	<span class="c-gray en">&gt;</span>
	基本设置
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
	<form class="form form-horizontal" id="form-goods-add">
		<div id="tab-system" class="HuiTab">
			<div class="tabBar cl">
				<span>基本信息</span>
				<span>扩展信息</span>
				<span>商品属性</span>
				<span>商品详情</span>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						商品名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="goods-title" name="goods_name" placeholder="控制在25个字、50个字节以内" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">所属栏目：</label>
					<div class="formControls col-xs-8 col-sm-10"> <span class="select-box" style="width:150px;">
						<select class="select" name="cat_id" size="1">
							<option value="0">选择栏目</option>
							<?php foreach($data as $v): ?>
								<option value="<?php echo $v['id']; ?>"><?php echo str_repeat('--',$v['lev']); ?><?php echo $v['cate_name']; ?></option>
							<?php endforeach; ?>
						</select>
						</span> </div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						本店价格：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="shop_price" name="shop_price" placeholder="5个左右,8汉字以内,用英文,隔开" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						市场价格：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="market_price" name="market_price" placeholder="5个左右,8汉字以内,用英文,隔开" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						商品库存：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="goods_number" name="goods_number" placeholder="5个左右,8汉字以内,用英文,隔开" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品图片：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="uploader-thum-container">
							<div id="fileList" class="uploader-list" style="margin_bottom:10px;"></div>
							<div id="filePicker">选择图片</div>
							<input type="hidden" id="goods_ori" name="goods_ori">
							<input type="hidden" id="goods_img" name="goods_img">
							<input type="hidden" id="goods_thumb" name="goods_thumb">
						</div>
					</div>
				</div>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否新品：</label>
					<div class="formControls col-xs-8 col-sm-10 skin-minimal">
						<div class="radio-box">
							<input name="is_new" type="radio" id="sex-1" value="0" checked>
							<label for="sex-1">否</label>
						</div>
						<div class="radio-box">
							<input type="radio" id="sex-2" value="1" name="is_new">
							<label for="sex-2">是</label>
						</div>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否热卖：</label>
					<div class="formControls col-xs-8 col-sm-10 skin-minimal">
						<div class="radio-box">
							<input name="is_hot" type="radio" id="sex-3" value="0" checked>
							<label for="sex-3">否</label>
						</div>
						<div class="radio-box">
							<input type="radio" id="sex-4" value="1" name="is_hot">
							<label for="sex-4">是</label>
						</div>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否精品：</label>
					<div class="formControls col-xs-8 col-sm-10 skin-minimal">
						<div class="radio-box">
							<input name="is_best" type="radio" id="sex-5" value="0" checked>
							<label for="sex-5">否</label>
						</div>
						<div class="radio-box">
							<input type="radio" id="sex-6" value="1" name="is_best">
							<label for="sex-6">是</label>
						</div>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否上架：</label>
					<div class="formControls col-xs-8 col-sm-10 skin-minimal">
						<div class="radio-box">
							<input name="is_sale" type="radio" id="sex-7" value="0" checked>
							<label for="sex-7">否</label>
						</div>
						<div class="radio-box">
							<input type="radio" id="sex-8" value="1" name="is_sale">
							<label for="sex-8">是</label>
						</div>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">商品描述：</label>
					<div class="formControls col-xs-8 col-sm-10">
						<textarea name="goods_desc" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)"></textarea>
						<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
					</div>
				</div>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">商品类型：</label>
					<div class="formControls col-xs-8 col-sm-10"> <span class="select-box" style="width:150px;">
						<select class="select" id="goods_type_id" name="goods_type_id" size="1" onchange="show_attr()">
							<option value="0">选择类型</option>
							<?php foreach(get_type_info() as $v): ?>
								<option value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
							<?php endforeach; ?>
						</select>
						</span> </div>
				</div>
				<div id="showattr"></div>
			</div>
			<div class="tabCon">
				<textarea  name="goods_intro" id="goods_intro" style="width: 800px;height: 400px;"></textarea>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
				<button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
			</div>
		</div>
	</form>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/static/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/static/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/static/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/static/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/static/admin/lib/webuploader/0.1.5/webuploader.js"></script>
<script type="text/javascript" src="/static/admin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/static/admin/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/static/admin/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
UE.getEditor('goods_intro',{
	toolbars: [[
		'fullscreen', 'source', '|', 'undo', 'redo', '|',
		'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
		'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
		'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
		'directionalityltr', 'directionalityrtl', 'indent'
	]]
});
function show_attr(){
	var type_id=$("#goods_type_id").val();
	$.ajax({
		type:"post",
		url:"/admin/attribute/getAttributeByType",
		data: {type_id,type_id},
		success:function (data) {
			$("#showattr").html(data);
		}
	});
}
$("#form-goods-add").submit(function () {
	var data=$(this).serialize();
	// alert(data);
	$.ajax({
		type:"post",
		url:"<?php echo url('admin/goods/add'); ?>",
		data:data,
		success:function (data) {
			if (data.info==1){
				layer.alert("添加成功",function () {
					parent.window.location.href=parent.window.location.href;
					layer_close();
				})
			}else {
				layer.msg("添加失败："+data.msg,{icon:5,time:3000});
			}
		}
	});
	return false;
});
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	var uploader = WebUploader.create({
		auto: true,
		swf: '__Admin_/lib/webuploader/0.1.5/Uploader.swf',

		// 文件接收服务端。
		server: "<?php echo url('admin/goods/upimages'); ?>",

		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick: '#filePicker',

		// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
		resize: false,
		// 只允许选择图片文件。
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		}
	});
	uploader.on( 'uploadSuccess', function( file,data ) {
		var img="<img src='"+data.goods_thumb+"' width='100'>";
		$("#fileList").html(img);
		$("#goods_ori").val(data.goods_ori);
		$("#goods_img").val(data.goods_img);
		$("#goods_thumb").val(data.goods_thumb);
		layer.msg("上传文件成功",{icon:6,time: 1000});
	});
	$("#tab-system").Huitab({
		index:0
	});
});
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>
