<?php

namespace backend\controllers;

use Yii;
use common\models\Dates;
use backend\search\DatesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\GiftReceiver;
use common\models\Gift;
use backend\search\GiftSearch;
use common\helpers\StringHelper;
use common\models\GiftTag;
use common\models\Tag;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

/**
 * DatesController implements the CRUD actions for Dates model.
 */
class DatesController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => array_merge(Yii::$app->params['rules'], array(
                    [
                        'actions' => ['get-day', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['get-tag', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                        )
                ),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Dates models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dates model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) { // gift Receiver Id
        $dates = new Dates();
		$gift = new Gift();
		
		if (Yii::$app->request->isAjax && $dates->load(Yii::$app->request->post()) && $gift->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$dates = ActiveForm::validate($dates);
			$gift = ActiveForm::validate($gift);
			return $dates+$gift;
		}

		$dates->id_gift_receiver = $id;
		if ($dates->load(Yii::$app->request->post()) && $gift->load(Yii::$app->request->post())) {
			if ($dates->validate() && $gift->validate([
				'from',
				'to'
			])) {
				if ($dates->save()) {
					$gift->id_dates = $dates->id;
					$gift->save();
                    return $this->redirect(['gift-receiver/update', 'id' => $dates->id_gift_receiver]);
				} 
			}
		}

		return $this->renderAjax('partials/create', [
			'dates' => $dates,
			'gift' => $gift,
		]);
    }

    /**
     * Updates an existing Dates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $dates = $this->findModel($id);
		$gift = $dates->gift;
		
		if (Yii::$app->request->isAjax && $dates->load(Yii::$app->request->post()) && $gift->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$dates = ActiveForm::validate($dates);
			$gift = ActiveForm::validate($gift);
			return $dates+$gift;
		}
		
		if ($dates->load(Yii::$app->request->post()) && $gift->load(Yii::$app->request->post())) {
			if ($dates->validate() && $gift->validate([
				'from', 'to',
			])) {
				if ($dates->save() && $gift->save()) {
					return $this->redirect(['gift-receiver/update', 'id' => $dates->id_gift_receiver]);
				}
			}
		}

		return $this->renderAjax('partials/update', [
			'dates' => $dates,
			'gift' => $gift,
		]);
    }
    
   

    /**
     * Deletes an existing Dates model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
		$model->delete();
        return $this->redirect(['gift-receiver/update', 'id' => $model->id_gift_receiver]);
    }

    public function actionGetDay($month, $year = '') {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Dates::getMonthByDay($month, $year);
    }
    
     public function actionGetTag($name) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['results' => Tag::find()->select(['name', 'name AS id'])->where(['like', 'name', $name])->asArray()->all()];
	}

    /**
     * Finds the Dates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Dates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the GiftReceiver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GiftReceiver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelGiftReceiver($id) {
        if (($model = GiftReceiver::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the GiftReceiver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GiftReceiver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelGift($id_dates) {
        if (($model = Gift::find()->where(['id_dates' => $id_dates])->all()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
