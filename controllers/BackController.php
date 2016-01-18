<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\UploadForm;
use yii\web\UploadedFile;

class BackController extends Controller
{
	//public function init()
	//{  
	//    $this->getClientScript->registerCssFile(Yii::app()->baseUrl.'/css/home.css');
	//	$this->getClientScript->registerScriptFile(Yii::app()->baseUrl.'/css/index.css');
	//}
	public $myscript = '';
	//public $myscript = '<script>function logIn(){document.getElementById("logInLine").className = "active";document.getElementById("registerLine").className = "inactive";document.getElementById("test").innerHTML=\'<form class="form-signin" role="form" name="loginForm" method="post" action="/signIn"><input type="text" name="name" class="form-control form-magin" placeholder="用户名" required="" autofocus=""><input type="password" name="password" class="form-control form-magin" placeholder="密码" required=""><button class="btn btn-lg btn-primary btn-block form-magin" type="submit" data-dismiss="modal" id="loginButton">登录</button></form>\';}function register(){document.getElementById("registerLine").className = "active";document.getElementById("logInLine").className = "inactive";document.getElementById("test").innerHTML=\'<form class="form-signin" role="form" name="loginForm" method="post" action="/signIn"><select class="form-control form-magin"><option>学生</option><option>老师</option><option>管理员</option></select><input type="text" name="name" class="form-control form-magin" placeholder="用户名" required="" autofocus=""><input type="password" name="password" class="form-control form-magin" placeholder="密码" required=""><button class="btn btn-lg btn-primary btn-block form-magin" type="submit" data-dismiss="modal" id="loginButton">注册</button></form>\';}</script>';
	public $enableCsrfValidation = false;
	public function actionIndex()
    {
		$this->myscript = '<script>function logIn(){document.getElementById("logInLine").className = "active";document.getElementById("registerLine").className = "inactive";document.getElementById("test").innerHTML=\'<form class="form-signin" role="form" name="loginForm" method="post" action="/signIn"><input type="text" name="name" class="form-control form-magin" placeholder="用户名" required="" autofocus=""><input type="password" name="password" class="form-control form-magin" placeholder="密码" required=""><button class="btn btn-lg btn-primary btn-block form-magin" type="submit" data-dismiss="modal" id="loginButton">登录</button></form>\';}function register(){document.getElementById("registerLine").className = "active";document.getElementById("logInLine").className = "inactive";document.getElementById("test").innerHTML=\'<form class="form-signin" role="form" name="loginForm" method="post" action="/signIn"><select class="form-control form-magin"><option>学生</option><option>老师</option><option>管理员</option></select><input type="text" name="name" class="form-control form-magin" placeholder="用户名" required="" autofocus=""><input type="password" name="password" class="form-control form-magin" placeholder="密码" required=""><button class="btn btn-lg btn-primary btn-block form-magin" type="submit" data-dismiss="modal" id="loginButton">注册</button></form>\';}</script>';
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect('@web/back/student-home');
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			\Yii::$app->session->set('user_name' , $model->username);
			//$this->myscript = '<script type="text/javascript">$(document).ready(function(){$("input#upload").change(function () {$.ajaxFileUpload({url: \'http://127.0.0.1:8080/oopassignment/web/back/upload\',secureuri: false,data:{\'id\':\'upload\'},fileElementId:\'upload\',dataType: \'json\',success: function (data, status) {if( data["result"] == \'Success\' ) {alert("SUCESS");}else{alert("上传失败");}},error: function (data, status, e) {return;}});});$("a.upload").click(  function(){ $("input#upload").click();});$("input#upload").live("change", function () {alert(\'live\')$.ajaxFileUpload(config);$("input#upload").replaceWith(\'<input type="file" id="upload" name="UploadForm[file]" ></input>\');});});</script>';
            //return $this->render('//back/studentHome');
			//return $this->goBack();
			return $this->redirect('@web/back/student-home');
        } else {
            return $this->render('//back/index', [
                'model' => $model,
            ]);
        }
		return $this->render('//back/index');//,['myscript' => $this->myscript]);
    }
	public function actionAdminCheckResult()
    {
        return $this->renderPartial('//back/adminCheckResult');
    }
	public function actionAdminHome()
    {
        return $this->renderPartial('//back/adminHome');
    }
	public function actionAdminInfo()
    {
        return $this->renderPartial('//back/adminInfo');
    }
	public function actionAdminPassword()
    {
        return $this->renderPartial('//back/adminPassword');
    }
	public function actionStudentHome()
    {
		//$this->myscript = '<script type="text/javascript">$(document).ready(function(){$("input#upload").change(function () {$.ajaxFileUpload({url: \'http://127.0.0.1:8080/oopassignment/web/back/upload\',secureuri: false,data:{\'id\':\'upload\'},fileElementId:\'upload\',dataType: \'json\',success: function (data, status) {if( data["result"] == \'Success\' ) {alert("SUCESS");}else{alert("上传失败");}},error: function (data, status, e) {return;}});});$("a.upload").click(  function(){ $("input#upload").click();});$("input#upload").live("change", function () {alert(\'live\'); $.ajaxFileUpload(config);$("input#upload").replaceWith(\'<input type="file" id="upload" name="UploadForm[file]" ></input>\');});});</script>';
		//$this->myscript = '<script type="text/javascript"> $(document).ready(function(){ $("input#upload").change(function () {alert(\'nima\');  $.ajaxFileUpload({url: \'http://127.0.0.1:8080/oopassignment/web/back/upload\',secureuri: false,data:{\'id\':\'upload\'},fileElementId:\'upload\',dataType: \'json\',success: function (data, status) {if( data["result"] == \'Success\' ) {alert("上传成功");} else{alert("上传失败");}},error: function (data, status, e) {return;}});}); $("a.upload").click(  function(){ $("input#upload").click();}); $("input#upload").live("change", function () {alert(\'live\'); $.ajaxFileUpload(config); $("input#upload").replaceWith(\'<input type="file" id="upload" name="UploadForm[file]" ></input>\');});}); </script>';
		if (\Yii::$app->user->isGuest) {
            return $this->redirect('@web/back/index');
        }
        return $this->render('//back/studentHome');
    }
	public function actionStudentInfo()
    {
        return $this->renderPartial('//back/studentInfo');
    }
	public function actionStudentPassword()
    {
        return $this->renderPartial('//back/studentPassword');
    }
	public function actionStudentProgress()
    {
        return $this->renderPartial('//back/studentProgress');
    }
	public function actionStudentResult()
    {
        return $this->renderPartial('//back/studentResult');
    }
	public function actionTeacherHome()
    {
        return $this->renderPartial('//back/teacherHome');
    }
	public function actionTeacherInfo()
    {
        return $this->renderPartial('//back/teacherInfo');
    }
	public function actionTeacherPassword()
    {
        return $this->renderPartial('//back/teacherPassword');
    }
	
	public function actionCssHome()
    {
        return $this->renderPartial('//back/cssHome.css');
    }
	public function actionUpload(){
		//$this->refresh();
		$params=Yii::$app->request->post();
		//echo 'step1';
		$uid = \Yii::$app->session['user_name'];
		$model = new UploadForm();
		if (Yii::$app->request->isPost) {
			$model->file = UploadedFile::getInstance($model, 'file');
			if ($model->file && $model->validate()) {
				
				if(!file_exists('../download/'.$uid))mkdir('../download/'.$uid);
				$path='../download/'.$uid.'\\';
				//$path = '../download/';
				if(!file_exists($path))mkdir($path);
						
				$filename=$model->file->name;//. $model->file->extension;//$params['id'].'.' . $model->file->extension;
				if($model->file->saveAs($path.$filename))
					return json_encode(["result"=>"Success","url"=>$path.$filename]);
						
				else return json_encode(["result"=>"Fail"]);
			}
			return json_encode(["result"=>"ValidFail"]);
		}
		return json_encode(["result"=>"PostFail"]);
	}
}