<!DOCTYPE html>
<html lang="en">
 <head> 
  <meta charset="utf-8" /> 
  <title>dayBit</title> 
  <meta name="description" content="Creating Modal Window with Bootstrap" /> 
  <link href="http://lib.sinaapp.com/js/bootstrap/latest/css/bootstrap.min.css" rel="stylesheet" /> 
  <link href="css/home.css" rel="stylesheet" /> 
  <script src="__PUBLIC__/js/lib/jquery-1.9.1.js" type="text/javascript"></script>
  <script src="__PUBLIC__/js/dist/jquery.validate.js" type="text/javascript"></script>
 </head> 
 <body> 
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation"> 
   <div class="container"> 
    <div class="navbar-header"> 
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> 
     <a class="navbar-brand" href="adminHome.html">软件学院论文盲审系统</a> 
    </div> 
    <!-- Split button --> 
    <form class="navbar-form navbar-right"> 
     <div class="btn-group"> 
      <a href="adminInfo.html" class="btn btn-primary  active" role="button">管理员</a> 
      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button> 
      <ul class="dropdown-menu" role="menu"> 
       <li><a href="adminInfo.html">个人信息</a></li> 
       <li class="divider"></li> 
       <li> <a href="adminPassword.html">修改密码</a> </li> 
       <li class="divider"></li> 
       <li><a href="#">登出</a></li> 
      </ul> 
     </div> 
    </form> 
   </div> 
  </div> 
  <div class="container"> 
   <div class="row"> 
    <div class="col-xs-3 mt60"> 
     <ul class="nav nav-pills nav-stacked"> 
      <li class="text-muted"> <h3>论文盲审</h3> </li> 
      <li class="inactive"> <a href="adminHome.html"> 下载论文 </a> </li> 
      <li class="inactive"> <a href="adminCheckResult.html"> 查看查重结果 </a> </li> 
      <li class="text-muted"> <h3>个人信息</h3> </li> 
      <li class="active"><a href="adminInfo.html">个人主页</a></li> 
      <li class="inactive"><a href="adminPassword.html">修改密码</a></li> 
     </ul> 
    </div> 
    <div class="col-xs-9 mt100"> 
     <form class="form-horizontal" id = 'infoForm'> 
      <div class="form-group"> 
        <label for="inputEmail3" class="col-sm-2 control-label" id = "info_username" name = "info_username">用户名</label> 
	    <div class="col-sm-10">
	      <p class="form-control-static" id = "info_my_username">我的用户名</p>
	    </div>
      </div> 
      <div class="form-group"> 
       <label for="inputPassword3" class="col-sm-2 control-label" id = "info_gender" name = "info_gender">性别</label> 
       <div class="col-sm-10"> 
        <p class="form-control-static" id = "info_my_gender">我的性别</p>
       </div> 
      </div> 
      <div class="form-group"> 
       <label for="inputEmail3" class="col-sm-2 control-label">电子邮件</label> 
       <div class="col-sm-10"> 
        <input type="email" class="form-control" id = "info_email" name = "info_email" placeholder="Email" /> 
       </div> 
      </div> 
      <div class="form-group"> 
       <label for="inputPassword3" class="col-sm-2 control-label">电话</label> 
       <div class="col-sm-10"> 
        <input type="number" class="form-control" id = "info_telephone" name = "info_telephone"  placeholder="telephone number" /> 
       </div> 
      </div> 
      <div class="form-group"> 
       <div class="col-sm-offset-2 col-sm-10"> 
        <button type="submit" class="btn btn-default" id = "btn_modify">更改</button> 
       </div> 
      </div> 
     </form> 
    </div> 
   </div> 
  </div> 
<script type="text/javascript">

$('#infoForm').validate({
    errorElement:'span',
    success:function(label){
        
        },
    rules:{
		'info_telephone':{
			range:[11,11],
		}
    },
    messages:{
		'info_telephone':{
			range:'<code>   请输入11位手机号</code>',		
		}
	}
});

$(document).ready(function(){
	$.ajax({	
        url : "http://oop.he4she.net/admin/user-browse",  
        type : 'POST',  
        data : JSON.stringify([{
			"meta_data": {
				"logic_pkval": "stu123"                            /////////////////////////////////////////需要修改值
			},
			"src_data": 	{            
	
			} 
		}]),  
        dataType : 'json',  
        contentType : 'application/json',  
        success : function(data, status, xhr) {
			var info_data = data.ret_set[0].ret_data;
			document.getElementById("info_my_username").innerHTML = info_data.user_name;
			document.getElementById("info_email").value = info_data.email;
			document.getElementById("info_telephone").value = info_data.mobile;
			if (info_data.sex == 0)  { //0是女
				document.getElementById("info_my_gender").innerHTML = "女";
			} else {				//1是男
				document.getElementById("info_my_gender").innerHTML = "男";
			}
        },  
        error : function(xhr, error, exception) {      
			alert(error);
			
        }  
    }).done(function(data,textStatus) {
	
	}); 
});

$('#btn_modify').click(function() {
	$.ajax({	
        url : "http://oop.he4she.net/admin/user-modify",  
        type : 'POST',  
        data : JSON.stringify([{
			"meta_data": {
				"logic_pkval":"stu123"                            /////////////////////////////////////////需要修改值
			},
			"src_data": 	{
				"email" : $('#info_email').val(),
				"mobile": $('#info_telephone').val()
			} 
		}]),  
        dataType : 'json',  
        contentType : 'application/json',  
        success : function(data, status, xhr) {
			console.log(data);
        },  
        error : function(xhr, error, exception) {      
			alert(error);
			
        }  
    }).done(function(data,textStatus) {
	
	}); 


});

</script>  
 </body>
</html>