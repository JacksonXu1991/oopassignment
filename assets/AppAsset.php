<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
		//'css/home.css',
		//'css/index.css',
    ];
    public $js = [
	'js/jquery.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
	 //定义按需加载JS方法，注意加载顺序在最后  
    //public static function addScript($view, $jsfile) {  
    //    $view->registerJsFile($jsfile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);  
    //}  
      
   //定义按需加载css方法，注意加载顺序在最后  
    public static function addCssHome($view) {  
        $view->registerCssFile('@web/css/home.css');//, [AppAsset::className(), 'depends' => 'yii\web\YiiAsset']);  
    } 
	public static function addCssIndex($view) {  
        $view->registerCssFile('@web/css/index.css');//, [AppAsset::className(), 'depends' => 'yii\web\YiiAsset']);  
    }
	public static function addJsIndex($view) {  
        $view->registerJsFile('@web/js/index-js.js',['depends'=>['app\assets\AppAsset']]);//,'position' => $view->context->POS_HEAD]);//, [AppAsset::className(), 'depends' => 'yii\web\YiiAsset']);  
    }
	public static function addJsAjaxFileUpLoad($view) {  
        $view->registerJsFile('@web/js/ajaxfileupload.js',['depends'=>['app\assets\AppAsset']]);//,'position'=>$view->context->POS_HEAD]);//, [AppAsset::className(), 'depends' => 'yii\web\YiiAsset']);  
    }
	public static function addJsAjaxFileUpLoadClickUploadButtton($view) {  
        $view->registerJsFile('@web/js/clickuploadfuction.js',['depends'=>['app\assets\AppAsset']]);//,'position'=>$view->context->POS_HEAD]);//, [AppAsset::className(), 'depends' => 'yii\web\YiiAsset']);  
    }
}
