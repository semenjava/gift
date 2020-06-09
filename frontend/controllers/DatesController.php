<?php

namespace frontend\controllers;

use Yii;
use common\models\Dates;
use common\models\Gift;
use common\models\GiftReceiver;
use common\models\Tag;
use frontend\models\DatesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DatesController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
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
	public function actionIndex($idGiftReceiver) {
		$searchModel = new DatesSearch();
		return $this->render('index', [
			'giftReceiver' => GiftReceiver::findOne($idGiftReceiver),
			'searchModel' => $searchModel,
			'dataProvider' => $searchModel->search(Yii::$app->request->queryParams, $idGiftReceiver),
		]);
	}

	/**
	 * @param string $idGiftReceiver
	 * @return mixed
	 */
	public function actionCreate($idGiftReceiver) {
		$dates = new Dates();
		$gift = new Gift();

		$dates->id_gift_receiver = $idGiftReceiver;
		if ($dates->load(Yii::$app->request->post()) && $gift->load(Yii::$app->request->post())) {
			if ($dates->validate() && $gift->validate([
				'from',
				'to'
			])) {
				if ($dates->save()) {
					$gift->id_dates = $dates->id;
					$gift->save();
					return $this->redirect(['index', 'idGiftReceiver' => $dates->id_gift_receiver]);
				}
			}
		}

		return $this->render('create', [
			'dates' => $dates,
			'gift' => $gift,
		]);
	}

	/**
	 * @param string $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id) {
		$dates = $this->findModel($id);
		$gift = $dates->gift;

		if ($dates->load(Yii::$app->request->post()) && $gift->load(Yii::$app->request->post())) {
			if ($dates->validate() && $gift->validate([
				'from', 'to',
			])) {
				if ($dates->save() && $gift->save()) {
					return $this->redirect(['index', 'idGiftReceiver' => $dates->id_gift_receiver]);
				}
			}
		}

		return $this->render('update', [
			'dates' => $dates,
			'gift' => $gift,
		]);
	}

	/**
	 * @param string $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id) {
		$model = $this->findModel($id);
		$model->delete();
		return $this->redirect(['index', 'idGiftReceiver' => $model->id_gift_receiver]);
	}

	public function actionGetTag($name) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['results' => Tag::find()->select(['name', 'name AS id'])->where(['like', 'name', $name])->asArray()->all()];
	}

	/**
	 * @param string $id
	 * @return Dates the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Dates::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
