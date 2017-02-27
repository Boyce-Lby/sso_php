(function(){
	var w = window;
	w.LBY_SSO = {
			Configure :{
				SSO_Server: 'text.me',
				Cross_Domain: true,   //是否跨域
			},
			checkLogin:function(args){
				$.ajax({
					url:LBY_SSO.Configure.SSO_Server+'/?c=Auth&a=checkLogin',
					xhrFields: {withCredentials: LBY_SSO.Configure.Cross_Domain},
					dataType:'json',
					type:'post',
					data:{id:1},
					success:function(data){
						if(data.login == 'no'){
							args.Fail();
						}else if(data.login == 'yes'){
							args.tmptoken = data.tmptoken;
							LBY_SSO.authToken(args);
						}
					},
					error:function(err){
						console.log(err);
					}
				})
				
			},
			authToken: function(args){
				$.ajax({
					url:LBY_SSO.Configure.SSO_Server+'/?c=Auth&a=authToken',
					xhrFields: {withCredentials: true},
					dataType:'json',
					type:'post',
					data:{tmptoken:args.tmptoken},
					success:function(data){
						if(data.auth == 'FAIL'){
							args.Fail();
						}else if(data.auth == 'SUC'){
							//将UserId存储到session中
							$.ajax({
								url:args.setSession_Url,
								dataType:'json',
								type:'post',
								data:{sessionId:data.sessionId},
								success:function(data){
									if(data.auth == 'SUC'){
										args.Suc();
									}else if(data.auth == 'FAIL'){
										args.Fail();
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
			},
			Login:function(args){
				console.log(args);
				var user = args.user;
				var pwd = args.pwd;
				$.ajax({
					url:args.Login_Url,
					dataType:'json',
					type:'post',
					data:{username:user,password:pwd},
					success:function(data){
						console.log(data);
						if(data.auth == 'SUC'){
							args.token = data.token;
							args.userid = data.userid;
							LBY_SSO.checkToken(args);
						}else{
							args.Fail();
						}
					},
					error:function(err){
						console.log(err);
					}
				})
			},
			checkToken:function(args){
				$.ajax({
					url:LBY_SSO.Configure.SSO_Server+'/?c=Auth&a=checkToken',
					xhrFields: {withCredentials: LBY_SSO.Configure.Cross_Domain},
					dataType:'json',
					type:'post',
					data:{token:args.token,userid:args.userid},
					success:function(data){
						console.log(data);
						args.Suc();
					},
					error:function(err){
						console.log(err);
					}
				})
			},
			Logout:function(args){
				$.ajax({
	    			url:LBY_SSO.Configure.SSO_Server+'/?c=Auth&a=logout',
	    			xhrFields: {withCredentials: LBY_SSO.Configure.Cross_Domain},
	    			dataType:'json',
	    			type:'post',
	    			data:{id:1},
	    			success:function(data){
	    				if(data.logout == 'SUC'){
	    					args.logout(data);
	    				}
	    			},
	    			error:function(err){
	    				console.log(err);
	    			}
				})
			}
	}
})();