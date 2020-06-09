<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Modal extends Widget
{
    public function run()
    {
        return $this->render('modal/modal');
    }
}
