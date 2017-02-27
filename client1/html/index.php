<?php 
    header("Access-Control-Allow-Origin:'http://client1.me'");
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
		Onmpw_SSO.checkLogin({
			Fail:function(){
				$("#login").show();
			},
			Suc:function(){
				$.ajax({
					url:'/getinfo.php',
					dataType:'json',
					type:'post',
					data:{sessionId:111},
					success:function(data){
						$("#userinfo").show();
					},
					error:function(err){
						console.log(err);
					}
				})
			},
			setSession_Url:'/auth.php',
		});

		$(".login").click(function(){
			Onmpw_SSO.Login({
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
			Onmpw_SSO.Logout({
				logout:function(data){
					$.ajax({
						url:'/logout.php',
						dataType:'json',
						type:'post',
						data:{sessionId:data.sessionId},
						success:function(data){
							if(data.logout == 'SUC'){
								location.reload();
							}
						},
						error:function(err){
							console.log(err);
						}
					})
				}
				
			})
    	})
	})
</script><script type="text/javascript">
$(function(){
	/*$.ajax({
		url:'http://192.168.5.111/?c=Auth&a=checkLogin',
		xhrFields: {withCredentials: true},
		dataType:'json',
		type:'post',
		data:{id:1},
		success:function(data){
			console.log(data);
			if(data.login == 'no'){
				$("#login").show();
			}else if(data.login == 'yes'){
				$.ajax({
					url:'http://192.168.5.111/?c=Auth&a=authToken',
					xhrFields: {withCredentials: true},
					dataType:'json',
					type:'post',
					data:{tmptoken:data.tmptoken},
					success:function(data){
						if(data.auth == 'SUC'){
							$.ajax({
								url:'/auth.php',
								dataType:'json',
								type:'post',
								data:{sessionId:data.sessionId},
								success:function(data){
									if(data.auth == 'SUC'){
										$.ajax({
											url:'/getinfo.php',
											dataType:'json',
											type:'post',
											data:{sessionId:data.sessionId},
											success:function(data){
												console.log(data);
												if(data.auth == 'SUC'){
													$("#userinfo").show();
												}else if(data.auth == 'FAIL'){
													$("#login").show();
												}
											},
											error:function(err){
												console.log(err);
											}
										})
										$("#userinfo").show();
									}else if(data.auth == 'FAIL'){
										$("#login").show();
									}
								},
								error:function(err){
									console.log(err);
								}
							})
						}else if(data.auth == 'FAIL'){
							$("#login").show();
						}
					},
					error:function(err){
						console.log(err);
					}
				})
			}
		},
		error:function(err){
			console.log(err);
		}
	})
	$(".login").click(function(){
		var user = $(".username").val();
		var pwd = $(".password").val();
		$.ajax({
			url:'/login.php',
			dataType:'json',
			type:'post',
			data:{username:user,password:pwd},
			success:function(data){
				if(data.auth == 'SUC'){
					$.ajax({
						url:'http://192.168.5.111/?c=Auth&a=checkToken',
						xhrFields: {withCredentials: true},
						dataType:'json',
						type:'post',
						data:{token:data.token,userid:data.userid},
						success:function(data){
							console.log(data);
							location.reload();
						},
						error:function(err){
							console.log(err);
						}
					})
				}
			},
			error:function(err){
				console.log(err);
			}
		})
	});*/
	/*$(".logout").click(function(){
		$.ajax({
			url:'http://192.168.5.111/logout.php',
			xhrFields: {withCredentials: true},
			dataType:'json',
			type:'post',
			data:{id:1},
			success:function(data){
				if(data.logout == 'SUC'){
					$.ajax({
						url:'/logout.php',
						dataType:'json',
						type:'post',
						data:{sessionId:data.sessionId},
						success:function(data){
							console.log(data);
							if(data.logout == 'SUC'){
								location.reload();
							}
						},
						error:function(err){
							console.log(err);
						}
					})
				}
			},
			error:function(err){
				console.log(err);
			}
		})

	})*/
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