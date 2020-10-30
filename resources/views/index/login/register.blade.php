<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>个人注册</title>


    <link rel="stylesheet" type="text/css" href="/static/index/css/webbase.css" />
    <link rel="stylesheet" type="text/css" href="/static/index/css/pages-register.css" />
</head>

<body>
	<div class="register py-container ">
		<!--head-->
		<div class="logoArea">
			<a href="" class="logo"></a>
		</div>
		<!--register-->
		<div class="registerArea">
			<h3>注册新用户<span class="go">我有账号，去<a href="{{url('login/login')}}" target="_blank">登录</a></span></h3>
			<div class="info">
				<form action="{{url('login/registerdo')}}" method="post" class="sui-form form-horizontal">
				@csrf
					<div class="control-group">
						<label class="control-label">用户名：</label>
						<div class="controls">
							<input type="text" name="user_name" placeholder="请输入你的用户名" class="input-xfat input-xlarge">
							<b style="color:red">{{$errors->first('user_name')}}</b>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">邮箱：</label>
						<div class="controls">
							<input type="text" name="user_email" placeholder="请输入你的邮箱" class="input-xfat input-xlarge">
							<b style="color:red">{{$errors->first('user_email')}}</b>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">手机号：</label>
						<div class="controls">
							<input type="text" name="user_tel" placeholder="请输入你的手机号" class="input-xfat input-xlarge">
							<b style="color:red">{{$errors->first('user_tel')}}</b>
						</div>
					</div>

					<div class="control-group">
						<label for="inputPassword" class="control-label">登录密码：</label>
						<div class="controls">
							<input type="password" name="user_pwd" placeholder="设置登录密码" class="input-xfat input-xlarge">
							<b style="color:red">{{$errors->first('user_pwd')}}</b>
						</div>
					</div>

					<div class="control-group">
						<label for="inputPassword" class="control-label">确认密码：</label>
						<div class="controls">
							<input type="password" name="confirm_pwd" placeholder="再次确认密码" class="input-xfat input-xlarge">
							<b style="color:red">{{$errors->first('confirm_pwd')}}</b>
						</div>
					</div>

					<div class="control-group">
						<label for="inputPassword" class="control-label">短信验证码：</label>
						<div class="controls">
							<input type="text" name="" placeholder="短信验证码" class="input-xfat input-xlarge">  <a href="#">获取短信验证码</a>
							<b style="color:red">{{$errors->first('')}}</b>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label"></label>
						<div class="controls btn-reg">
							<button type="submit" class="sui-btn btn-block btn-xlarge btn-danger">完成注册</button>
						</div>
					</div>
				</form>
				<div class="clearfix"></div>
			</div>
		</div>
		<!--foot-->
		<div class="py-container copyright">
			<ul>
				<li>关于我们</li>
				<li>联系我们</li>
				<li>联系客服</li>
				<li>商家入驻</li>
				<li>营销中心</li>
				<li>手机品优购</li>
				<li>销售联盟</li>
				<li>品优购社区</li>
			</ul>
			<div class="address">地址：北京市昌平区建材城西路金燕龙办公楼一层 邮编：100096 电话：400-618-4000 传真：010-82935100</div>
			<div class="beian">京ICP备08001421号京公网安备110108007702
			</div>
		</div>
	</div>


<script type="text/javascript" src="/static/index/js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/static/index/js/plugins/jquery.easing/jquery.easing.min.js"></script>
<script type="text/javascript" src="/static/index/js/plugins/sui/sui.min.js"></script>
<script type="text/javascript" src="/static/index/js/plugins/jquery-placeholder/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="/static/index/js/pages/register.js"></script>
</body>

</html>