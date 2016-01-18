<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
	<title>软件学院论文盲审系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    
    <?php $this->head() ?>
	<?php 
	echo $this->context->myscript;
	$this->context->myscript = '';
	?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $content ?>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
