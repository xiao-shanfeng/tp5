<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"E:\vhost\tpshop\public/../application/admin\view\attribute\add.html";i:1551788755;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/static/admin/lib/html5shiv.js"></script>
<script type="text/javascript" src="/static/admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/static/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>添加类型 - 商品管理 - H-ui.admin v3.1</title>
<meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-attr-add">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>属性名称：</label>
		<div class="formControls col-xs-8 col-sm-10">
			<input type="text" class="input-text" value="" placeholder="" id="attr_name" name="attr_name">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品类型：</label>
		<div class="formControls col-xs-8 col-sm-10"> <span class="select-box" style="width:150px;">
		<select class="select" name="type_id" size="1">
			<option value="0">选择类型</option>
			<?php foreach(get_type_info() as $v): ?>
				<option value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
			<?php endforeach; ?>
		</select>
		</span> </div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>属性类型：</label>
		<div class="formControls col-xs-8 col-sm-10 skin-minimal">
			<div class="radio-box">
				<input name="attr_type" type="radio" id="sex-1" value="0" checked>
				<label for="sex-1">唯一属性</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="sex-2" value="1" name="attr_type">
				<label for="sex-2">单选属性</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>录入方式：</label>
		<div class="formControls col-xs-8 col-sm-10 skin-minimal">
			<div class="radio-box">
				<input name="attr_input_type" type="radio" id="sex-3" checked value="0">
				<label for="sex-3">手工录入</label>
			</div>
			<div class="radio-box">
				<input type="radio" id="sex-4" name="attr_input_type" value="1">
				<label for="sex-4">列表选择</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-2">可选值列表：</label>
		<div class="formControls col-xs-8 col-sm-10">
			<textarea name="attr_value" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)"></textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-10 col-xs-offset-4 col-sm-offset-2">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>

<!--_footer 作为公共模版分离出去--> 
<script type="text/javascript" src="/static/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/static/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/static/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/static/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="/static/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="/static/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script> 
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-attr-add").submit(function () {
		var data=$(this).serialize();
		// alert(data);
		$.ajax({
			type:"post",
			url:"<?php echo url('admin/attribute/add'); ?>",
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
	})
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>