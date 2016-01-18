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
      <li class="inactive"><a href="adminInfo.html">个人主页</a></li> 
      <li class="active"><a href="adminPassword.html">修改密码</a></li> 
     </ul> 
    </div> 
    <div class="col-xs-9 mt100"> 
     <form id = "passwordForm" onsubmit = "return dectects()"> 
      <div class="form-group"> 
       <label for="exampleInputPassword1">新密码</label> 
       <input type="password" class="form-control" id = "newPassword" name = "newPassword" placeholder="Password" /> 
      </div> 
      <div class="form-group"> 
       <label for="exampleInputPassword1">新密码确认</label> 
       <input type="password" class="form-control" id = "newPasswordComfirmed" name = "newPasswordComfirmed" placeholder="Password Confirmed" /> 
      </div> 
      <button type="submit" class="btn btn-default" >提交</button> 
     </form> 
    </div> 
   </div> 
  </div>
<script type="text/javascript">

function dectects() {
	var v1 = document.getElementById('newPassword').value;
	var v2 = document.getElementById('newPasswordComfirmed').value;
	if (v1 != v2) {
		alert("两次输入的密码不相同!");
		return false;
	}
	return true;
}

$('#passwordForm').validate({
    errorElement:'span',
    success:function(label){
        
        },
    rules:{
		'newPassword':{
			required:true,
			minlength:6,
			maxlength:32
		},
		'newPasswordComfirmed':{
			minlength:6,
			maxlength:32
		}
    },
    messages:{
		'newPassword':{
			required:'<code>   必填</code>',
			minlength:'<code>   密码不少于6位</code>',	
			maxlength:'<code>   密码不超过32位</code>'		
		},
		'newPasswordComfirmed':{
			minlength:'<code>   密码不少于6位</code>',	
			maxlength:'<code>   密码不超过32位</code>'				
		}
	}
});

</script>    
 </body>
</html>

