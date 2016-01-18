<!DOCTYPE html>
<html lang="en">
 <head> 
  <meta charset="utf-8" /> 
  <title>dayBit</title> 
  <meta name="description" content="Creating Modal Window with Bootstrap" /> 
  <link href="http://lib.sinaapp.com/js/bootstrap/latest/css/bootstrap.min.css" rel="stylesheet" /> 
  <link href="css/home.css" rel="stylesheet" /> 
 </head> 
 <body> 
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation"> 
   <div class="container"> 
    <div class="navbar-header"> 
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> 
     <a class="navbar-brand" href="studentHome.html">软件学院论文盲审系统</a> 
    </div> 
    <!-- Split button --> 
    <form class="navbar-form navbar-right"> 
     <div class="btn-group"> 
      <a href="studentInfo.html" class="btn btn-primary  active" role="button">学生</a> 
      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button> 
      <ul class="dropdown-menu" role="menu"> 
       <li><a href="studentInfo.html">个人信息</a></li> 
       <li class="divider"></li> 
       <li> <a href="studentPassword.html">修改密码</a> </li> 
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
      <li class="inactive"> <a href="studentHome.html"> 上传论文 </a> </li> 
      <li class="inactive"> <a href="studentProgress.html"> 查看评审进度 </a> </li> 
      <li class="active"> <a href="studentResult.html"> 查看评审结果 </a> </li> 
      <li class="text-muted"> <h3>个人信息</h3> </li> 
      <li><a href="studentInfo.html">个人主页</a></li> 
      <li><a href="studentPassword.html">修改密码</a></li> 
     </ul> 
    </div> 
    <div class="col-xs-9 mt100"> 
     <h2>评审结果：优、良、中、不及格</h2> 
    </div> 
   </div> 
  </div> 
  <script src="http://lib.sinaapp.com/js/jquery/2.0.3/jquery-2.0.3.js"></script> 
  <!-- Include all compiled plugins (below), or include individual files as needed --> 
  <script src="http://lib.sinaapp.com/js/bootstrap/latest/js/bootstrap.min.js"></script>   
 </body>
</html>