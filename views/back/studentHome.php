<?php
use yii\helpers\Html;
use app\assets\AppAsset;
AppAsset::register($this);
AppAsset::addJsAjaxFileUpLoad($this);
AppAsset::addJsAjaxFileUpLoadClickUploadButtton($this);
AppAsset::addCssHome($this);
//AppAsset::addJsIndex($this);
?>


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
      <li class="active"> <a href="studentHome.html"> 上传论文 </a> </li> 
      <li class="inactive"> <a href="studentProgress.html"> 查看评审进度 </a> </li> 
      <li class="inactive"> <a href="studentResult.html"> 查看评审结果 </a> </li> 
      <li class="text-muted"> <h3>个人信息</h3> </li> 
      <li><a href="studentInfo.html">个人主页</a></li> 
      <li><a href="studentPassword.html">修改密码</a></li> 
     </ul> 
    </div> 
	
    <div class="col-xs-9 mt100"> 
     <div class="panel panel-primary"> 
	 
      <div class="panel-heading">
       选择文件
      </div> 
      <div class="panel-body"> 
<a href ="../../download/demo/1.dll"> hehhehe</a> 
        <div class="form-group"> 
		
		 <a href='#' class="upload" id="auploads">上传</a>
		 <div style="display:none"><input  class = "btn btn-default btn-lg btn-block" type="file" id="upload" name="UploadForm[file]" />  </div>
		 
         
        </div> 

      </div> 
      <div class="panel-footer"> 
       <li class="help-block">必须是 PDF 格式文件</li> 
       <li class="help-block">文件大小小于 10 M</li> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div> 
 
