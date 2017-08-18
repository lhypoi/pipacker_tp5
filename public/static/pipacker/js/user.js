$(function (){
	function user_option(){
		// this.user_id=logcalStorage.getItem("user_id");
		// this.data={}
	};
	user_option.prototype={
		haslogin:function(){
			if(this.user_id>0){
				return true;
			}else{
				return false;
			}
		},
		check_phone:function(val){
			// console.log(val);
			if(/^1[34578]\d{9}$/.test(val)){
				return true;
			}else{
				return false;
			}
		},
		//登录
		login:function() {
			$user_phone = $("#user_phone");
			$user_pwd = $("#user_pwd");
			$user_phone_text = '';
			$user_pwd_text = '';
			$user_phone.on('blur',function() {
				$user_phone_text = $user_phone.val();
				if($user_phone_text != "") {
					if(/^1[34578]\d{9}$/.test($user_phone_text)) {
						$.get(register_url,{"user_phone":$user_phone_text},function(data){
							if (!$.isEmptyObject(data)) {
								var redata = $.parseJSON(data);
								if(0==redata.status){
									console.log('用户名已存在!');	
									$(".lotips").eq(0).removeClass("glyphicon-remove-circle").addClass("glyphicon-ok-circle");
								}else{
									$(".lotips").eq(0).removeClass("glyphicon-ok-circle").addClass("glyphicon-remove-circle");
									$user_phone_text ="";
								}
							}else{
								alert("等待通信中...");
							}
						});
					} else {
						$(".lotips").eq(0).removeClass("glyphicon-ok-circle").addClass("glyphicon-remove-circle");
						$user_phone_text = '';
					}
				} else {
					$(".lotips").eq(0).removeClass("glyphicon-ok-circle").addClass("glyphicon-remove-circle");
					$user_phone_text = '';
				}
			})
			$user_pwd.on('blur',function() {
				$user_pwd_text = $user_pwd.val();
				if($user_pwd != "") {
					 if(/^(\w){6,20}$/.test($user_pwd_text)) {
						$(".lotips").eq(1).removeClass("glyphicon-remove-circle").addClass("glyphicon-ok-circle");

					} else {
						$(".lotips").eq(1).removeClass("glyphicon-ok-circle").addClass("glyphicon-remove-circle");
						$user_pwd_text = '';
					}
				} else {
					$(".lotips").eq(1).removeClass("glyphicon-ok-circle").addClass("glyphicon-remove-circle");
					$user_pwd_text = '';
				}
			})
			
			$(".pp_login_btn").on('click',function() {
				if ($user_phone_text != '') {
					if ($user_pwd_text != '') {
						var userData = {
							"user_phone":$user_phone_text,
							"user_pwd":$user_pwd_text
						}
						$.get(register_url,userData,function(Data) {
							if (!$.isEmptyObject(Data)) {
								var redata = $.parseJSON(Data);
								console.log(redata);
								if (0 == redata.status) {
<<<<<<< HEAD
									localStorage.setItem("user_phone",redata.rearray[0].user_phone);
									// localStorage.setItem("user_pwd",redata[0].user_pwd);
									localStorage.setItem("user_name",redata.rearray[0].user_name);
									localStorage.setItem("user_id",redata.rearray[0].user_id);
=======
									localStorage.setItem("user_phone",redata.rearray.user_phone);
									// localStorage.setItem("user_pwd",redata[0].user_pwd);
									localStorage.setItem("user_name",redata.rearray.user_name);
									localStorage.setItem("user_id",redata.rearray.user_id);
>>>>>>> d0907dfb0679258f58f914a9e11d3c0bec0da60c
									$("#pp_login").modal('hide');
									$(".modal-backdrop").hide();
									// alert('登录成功');
									console.log(localStorage);
								} else if (1 == redata.status) {
									alert("密码有误");
								}
							}
						})
					} else {
						$(".lotips").eq(1).removeClass("glyphicon-ok-circle").addClass("glyphicon-remove-circle");
					}
				} else {
					$(".lotips").eq(0).removeClass("glyphicon-ok-circle").addClass("glyphicon-remove-circle");
				}
			})
		},
		register:function(){
			var $user_info = $("input.user_info");
			var $user_tips = $("span.retips");
			var user_phone = "";
			var user_pwd = "";
			var user_repwd = "";
			// console.log($user_tips);
			$user_info.eq(0).on('blur',function(){	
				user_phone = $user_info.eq(0).val();
				if(''!=user_phone){
					if(that.check_phone(user_phone)){
						$user_tips.eq(0).removeClass('glyphicon-remove-circle').addClass('glyphicon-ok-circle');
						$.get(register_url,{"user_phone":user_phone},function(data){
							if (!$.isEmptyObject(data)) {
								var redata = $.parseJSON(data);
								if(0==redata.status){
									console.log('用户名已存在!');
									$user_tips.eq(0).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
									user_phone="";
								}
							}else{
								alert("等待通信中...");
							}
					});
					}else{
						$user_tips.eq(0).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
						user_phone="";
					}
				}else{
					$user_tips.eq(0).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
					user_phone= '';
				}
					
			});
			$user_info.eq(2).on('blur',function(){					
				user_pwd = $user_info.eq(2).val();;
				if('' != user_pwd){
					console.log(user_pwd.length);
					if(user_pwd.length>7){
						$user_tips.eq(2).removeClass('glyphicon-remove-circle').addClass('glyphicon-ok-circle');
					}else{
						$user_tips.eq(2).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
						user_pwd = "";
					}
				}else{
					$user_tips.eq(2).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
					user_pwd="";
				}
					
			});
			$user_info.eq(3).on('blur',function(){					
				user_repwd = $user_info.eq(3).val();;
				if('' != user_repwd){
					if(user_pwd==user_repwd){
						$user_tips.eq(3).removeClass('glyphicon-remove-circle').addClass('glyphicon-ok-circle');
					}else{
						$user_tips.eq(3).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
						user_repwd="";
					}
				}else{
					$user_tips.eq(3).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
					user_repwd="";
				}
					
			});
			var that = this; 
			$(".pp_reg_btn").on("click",function(){
				if(""!=user_phone){
					if(""!=user_repwd){
						if(user_pwd==user_repwd){
							var params = {
								"user_phone":user_phone,
								"user_pwd":user_repwd,
								"user_name":$user_info.eq(1).val()
							}

							// console.log(params);
							//注册的地址在这了了了
								$.post(register_url,params,function(data){
									if (!$.isEmptyObject(data)) {
										var redata = $.parseJSON(data);
										if(0 == redata.status){
											$("#pp_reg").modal("hide");
											$("#pp_login").modal("show");
										}else{
											console(redata.msg);
										}
									}else{
										alert("与服务器通信失败...");
									}
								});
						}else{
							$user_tips.eq(2).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
						}
					}else{
						$user_tips.eq(3).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
					}
				}else{
					$user_tips.eq(0).removeClass('glyphicon-ok-circle').addClass('glyphicon-remove-circle');
				}
			});
		},
		logout:function(){

		},
		init:function(){
			this.register();
			this.login();
		}

	}
	var user_option = new user_option();
	user_option.init();
});