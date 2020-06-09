<?php

namespace app\modules\v1_1\controllers;

use Yii;
use app\modules\v1_1\components\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use common\models\Dates;
use common\models\Gift;
use common\models\Tag;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use common\helpers\StringHelper;

class DatesController extends ActiveController {

    /**
     *
     * @var string
     */
    public $modelClass = 'common\models\Dates';


    /**
     *
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
        $behaviors ['verbs'] = [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ];
        return $behaviors;
    }

    public function actionGet($id) {
        $dates = Dates::find()->where(['id' => $id])->with(['holiday', 'gift'])->asArray()->one();
        if ($dates) {
            if(!empty($dates['custom_holiday'])) {
                $dates['custom_holiday'] = StringHelper::decodeEmoji($dates['custom_holiday']);
            }

			if(!empty($dates['gift']) && empty($dates['gift']['tags'])) {
				$dates['gift']['tags'] = ArrayHelper::toArray(Gift::getTagsById($dates['gift']['id']));
			}

			if(!empty($dates['birthday'])) {
				unset($dates['birthday']);
			}

            return $this->responseSuccess($dates);
        }
        return $this->responseFail('There is no such date by id '.$id);
    }

    public function actionGetList($id_gift_receiver) {
        $dates = Dates::find()
                        ->where(['id_gift_receiver' => $id_gift_receiver])
                        ->with(['holiday', 'gift'])->asArray()->all();
        if ($dates) {
            foreach ($dates as $key => $value) {
                if(!empty($value['custom_holiday'])) {
                    $dates[$key]['custom_holiday'] = StringHelper::decodeEmoji($value['custom_holiday']);
                }

				if(!empty($value['gift']) && empty($value['gift']['tags'])) {
					$dates[$key]['gift']['tags'] = ArrayHelper::toArray(Gift::getTagsById($value['gift']['id']));
				}

				if(!empty($value['birthday'])) {
					unset($dates[$key]['birthday']);
				}
            }
            return $this->responseSuccess($dates);
        }
        return $this->responseFail('There is no such date by id_gift_receiver '.$id_gift_receiver);
    }

    public function actionCreate() {
        $dates = new Dates();
		$gift = new Gift();
		$post = Yii::$app->request->post();
		$tags = [];

		if ($dates->load($post) && $gift->load($post)) {
			if ($dates->validate() && $gift->validate(['from', 'to'])) {
				if ($dates->save()) {
					$gift->id_dates = $dates->id;
					$gift->save();
                    if(!empty($gift->tags)) {
						$tags['tags'] = ArrayHelper::toArray($gift->tags);
					}
					if(!empty($dates->birthday)) {
						unset($dates->birthday);
					}
					$arr = array_merge(['dates' => ArrayHelper::toArray($dates)], ['gift' => ArrayHelper::toArray($gift)]);
                    return $this->responseSuccess(array_merge($arr, $tags));
				}
			} else {
				$errors = array_merge($dates->errors, $gift->errors);
				return $this->responseErrorValid($errors);
			}
		}
		return $this->responseFail('Could not create dates');
    }

    public function actionUpdate($id) {
        $dates = $this->findModel($id);
		$gift = $dates->gift;
        $post = \Yii::$app->getRequest()->getBodyParams();
		$tags = [];

        if ($dates->load($post) && $gift->load($post)) {
			if ($dates->validate() && $gift->validate(['from', 'to'])) {
				if ($dates->save()) {
					$gift->id_dates = $dates->id;
					$gift->save();
					if(!empty($gift->tags)) {
						$tags['tags'] = ArrayHelper::toArray($gift->tags);
					}
					if(!empty($dates->birthday)) {
						unset($dates->birthday);
					}
					$arr = array_merge(['dates' => ArrayHelper::toArray($dates)], ['gift' => ArrayHelper::toArray($gift)]);
                    return $this->responseSuccess(array_merge($arr, $tags));
				}
			} else {
				$errors = array_merge($dates->errors, $gift->errors);
				return $this->responseErrorValid($errors);
			}
		}
		return $this->responseFail('Could not update dates '.$id);
    }

    public function actionDel($id) {

        $model = $this->findModel($id);
        $id_gift_receiver = $model->id_gift_receiver;
        $gift = $this->findModelGift($id);
        foreach ($gift as $obj) {
            $obj->delete();
        }

        return $this->responseSuccess($model->delete());
    }

	public function actionGetDay($month, $year = '') {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Dates::getMonthByDay($month, $year);
		$this->responseSuccess($data);
    }

     public function actionGetTag($name) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$data =  Tag::find()->select(['name', 'name AS id'])->where(['like', 'name', $name])->asArray()->all();
		$this->responseSuccess($data);
	}

    protected function findModel($id) {
        if (($model = Dates::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\ForbiddenHttpException('The requested page does not exist.');
    }

    protected function findModelGift($id_dates) {
        if (($model = Gift::find()->where(['id_dates' => $id_dates])->all()) !== null) {
            return $model;
        }
        throw new \yii\web\ForbiddenHttpException('The requested page does not exist.');
    }

}
