<?php

namespace frontend\controllers;

use Yii;
use common\models\GiftReceiver;
use frontend\models\GiftReceiverSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\helpers\StringHelper;

class GiftReceiverController extends Controller {

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
	* Lists all GiftReceiver models.
	* @return mixed
	*/
	public function actionIndex() {
		$searchModel = new GiftReceiverSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new GiftReceiver();

		if ($model->load(Yii::$app->request->post())) {
			$model->id_user = Yii::$app->user->identity->id;
			$model->is_active = true;

			if ($model->save()) {
				return $this->redirect(['/dates/index', 'idGiftReceiver' => $model->id]);
			}
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * @param string $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			if ($model->save()) {
				return $this->redirect(['/dates/index', 'idGiftReceiver' => $model->id]);
			}
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * @param string $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the GiftReceiver model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return GiftReceiver the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = GiftReceiver::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
