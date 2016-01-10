<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class AdminController extends Controller
{
    
    public function init(){
        $this->enableCsrfValidation = false;
    }
    

    public function actionTest()
    {
        return json_encode(
            [
                "hello" => "hello world",
            ]
            );
    }

}
