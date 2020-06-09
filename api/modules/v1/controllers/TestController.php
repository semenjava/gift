<?php

namespace app\modules\v1\controllers;

use yii\rest\Controller;

class TestController extends Controller  {
    public function actionTest() {
        return a();
    }
}
