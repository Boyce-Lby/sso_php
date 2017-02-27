<?php 
    header("Access-Control-Allow-Origin:'http://client.me'");//定义头文件origin
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://text.me/Common.js"></script>
<script type="text/javascript">
	$(function(){
		LBY_SSO.checkLogin({
			Fail:function(){
				$("#login").show();
			},
			Suc:function(){
				//验证成功获取用户数据
				// $.ajax({
				// 	url:'/getinfo.php',
				// 	dataType:'json',
				// 	type:'post',
				// 	data:{sessionId:111},
				// 	success:function(data){
				// 		$("#userinfo").show();
				// 	},
				// 	error:function(err){
				// 		console.log(err);
				// 	}
				// })
				$("#userinfo").show();
			},
			setSession_Url:'/auth.php',
		});

		$(".login").click(function(){
			LBY_SSO.Login({
				Login_Url: '/login.php',
				Fail: function(){
					$("#login").show();
				},
				Suc: function(){
					location.reload();
				},
				user: $(".username").val(),
				pwd : $(".password").val(),
			});
		});
		$(".logout").click(function(){
			LBY_SSO.Logout({
				// logout:function(data){
				// 	$.ajax({
				// 		url:'/logout.php',
				// 		dataType:'json',
				// 		type:'post',
				// 		data:{sessionId:data.sessionId},
				// 		success:function(data){
				// 			if(data.logout == 'SUC'){
				// 				location.reload();
				// 			}
				// 		},
				// 		error:function(err){
				// 			console.log(err);
				// 		}
				// 	})
				// }
				Suc:function(){
					location.reload();
				}
				
			})
    	})
	})
</script>
</head>
<body>
<div id='login' style="display:none;">
    <input type="text" name="username" placeholder="user" class="username" />
    <input type="hidden" name="hidden" class="sessionid" value='' />
    <input type="password" name="password" class="password" />
    <input type="submit" class="login" value="login" />
</div>
<div id="userinfo" style="display:none">
    Login Successfully!!
    <br />
    <input type='submit' name='logout' class='logout' value='logout' />
</div>
</body>
</html>