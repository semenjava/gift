<?php

namespace backend\controllers;

use Yii;
use common\models\GiftReceiver;
use backend\search\GiftReceiverSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Dates;
use backend\search\DatesSearch;
use common\helpers\StringHelper;
use common\models\Gift;
use backend\search\GiftSearch;
use common\models\Category;
use common\models\Product;

use backend\controllers\GiftController;


/**
 * GiftReceiverController implements the CRUD actions for GiftReceiver model.
 */
class GiftReceiverController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => array_merge(Yii::$app->params['rules'],
                        array(
                            [
                                'actions' => ['input', 'error'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                            [
                                'actions' => ['save', 'error'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                            [
                                'actions' => ['inputDelete', 'error'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                            [
                                'actions' => ['info', 'error'],
                                'allow' => true,
                                'roles' => ['@'],
                            ]
                        )
                    )
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
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
     * Displays a single GiftReceiver model.
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
     * Creates a new GiftReceiver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new GiftReceiver();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('partials/create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing GiftReceiver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $id_date = null) {
        $searchModel = new GiftReceiverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $this->findModel($id);

        $searchModelDates = new DatesSearch();
        $dataProviderDates = $searchModelDates->search(['id_gift_receiver' => $id]);

        $class['panel1']=null;
        $class['panel2']='active';

        if($model->load(Yii::$app->request->post())) {
            //save
            if ($model->save()) {
                $class['panel1']='active';
                $class['panel2']=null;

                return $this->render('partials/update', [
                            'model' => $model,
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'searchModelDates' => $searchModelDates,
                            'dataProviderDates' => $dataProviderDates,
                            'id_date' => $id_date,
                            'class' => $class
                ]);
            }
        }




        return $this->render('partials/update', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'searchModelDates' => $searchModelDates,
                    'dataProviderDates' => $dataProviderDates,
                    'id_date' => $id_date,
                    'class' => $class
        ]);
    }

    /**
     * Updates an existing GiftReceiver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSave() {
        $searchModel = new GiftReceiverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dates = new Dates;

        if (!empty(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();
            $model = $this->findModel($post['model_id']);

            $dates->id_gift_receiver = $model->id;
            $dates->mem_date = $post['Dates']['mem_date'];
            if (!empty($post['Dates']['id_holiday'])) {
                $dates->id_holiday = $post['Dates']['id_holiday'];
            }
            if (!empty($post['Dates']['custom_holiday'])) {
                $dates->custom_holiday = $post['Dates']['custom_holiday'];
            }
            $dates->save();

            return $this->render(['update', 'id' => $model->id, 'id_date' => $dates->id]);
        }

        return $this->render('partials/update', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dates' => $dates
        ]);
    }

    /**
     * Deletes an existing GiftReceiver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->is_active = 0;
        $model->update();
        return $this->redirect(['index']);
    }

    public function actionInputDelete($id) {
        $dates = Dates::findOne($id);
        $model_id = $dates->id_gift_receiver;
        Dates::findOne($id)->delete();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['delete', 'id' => $model_id, 'id_date' => $id];
    }

    /**
     * Finds the GiftReceiver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GiftReceiver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = GiftReceiver::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
