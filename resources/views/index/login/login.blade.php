<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>品优购，欢迎登录</title>

    <link rel="stylesheet" type="text/css" href="/static/index/css/webbase.css" />
    <link rel="stylesheet" type="text/css" href="/static/index/css/pages-login.css" />
</head>

<body>
	<div class="login-box">
		<!--head-->
		<div class="py-container logoArea">
			<a href="" class="logo"></a>
		</div>
		<!--loginArea-->
		<div class="loginArea">
			<div class="py-container login">
				<div class="loginform">
					<ul class="sui-nav nav-tabs tab-wraped">
						<li class="active">
							<a href="#profile" data-toggle="tab">
								<h3>账户登录</h3>
							</a>
						</li>
					</ul>
					<div class="tab-content tab-wraped">
						<div id="profile" class="tab-pane  active">

						@if(session('msg'))
							<div style="color:red">{{session('msg')}}</div>
						@endif

							<form action="{{url('login/logindo')}}" method="post" class="sui-form">
							@csrf
								<div class="input-prepend"><span class="add-on loginname"></span>
									<input type="text" name="user_name" placeholder="用户名/邮箱/手机号" class="span2 input-xfat">
									<b style="color:red">{{$errors->first('user_name')}}</b>
								</div>
								<div class="input-prepend"><span class="add-on loginpwd"></span>
									<input type="password" name="user_pwd" placeholder="请输入密码" class="span2 input-xfat">
									<b style="color:red">{{$errors->first('user_pwd')}}</b>
								</div>
								<div class="logined">
									<button type="submit" class="sui-btn btn-block btn-xlarge btn-danger">登&nbsp;&nbsp;录</button>
								</div>
							</form>
							<div class="otherlogin">
								<div class="types">
									<a href="https://github.com/login/oauth/authorize?client_id=de2b9614a1054a4de05f" target="_blank">GitHub登录</a>
								</div>
								<span class="register"><a href="{{url('login/register')}}" target="_blank">立即注册</a></span>
							</div>
						</div>
					</div>
				</div>
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
<script type="text/javascript" src="/static/index/js/pages/login.js"></script>
</body>

</html>