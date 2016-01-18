<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\AppAsset;
AppAsset::register($this);
AppAsset::addCssIndex($this);
AppAsset::addJsIndex($this);
?>

  
  <div class="container"> 
   <div id="title"> 
    <h2>软件学院</h2> 
    <h2>论文盲审系统</h2> 
   </div> 
   <!-- loginModal --> 
   <div id="loginWindow"> 
    <!--    <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">登录</h4>
                </div>  --> 
    <ul class="nav nav-tabs nav-justified form-magin"> 
     <li id="logInLine" role="presentation" class="active"><a onclick="logIn()">登陆</a></li> 
     <li id="registerLine" role="presentation" class="inactive"><a onclick="register()">注册</a></li> 
    </ul> 
    <div id="test" class="modal-body"> 
	<?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
	<?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
	<div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>
	<?php ActiveForm::end(); ?>
     <form class="form-signin" role="form" name="loginForm" method="post" action="/signIn"> 
      <input type="text" name="name" class="form-control form-magin" placeholder="用户名" required="" autofocus="" /> 
      <input type="password" name="password" class="form-control form-magin" placeholder="密码" required="" /> 
      <button class="btn btn-lg btn-primary btn-block form-magin" type="submit" data-dismiss="modal" id="loginButton">登录 </button> 
     </form> 
    </div> 
   </div> 

   <script src="http://lib.sinaapp.com/js/jquery/2.0.3/jquery-2.0.3.js"></script> 
   <!-- Include all compiled plugins (below), or include individual files as needed --> 
   <script src="http://lib.sinaapp.com/js/bootstrap/latest/js/bootstrap.min.js"></script> 
  </div>  

