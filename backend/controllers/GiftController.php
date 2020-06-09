<?php

namespace backend\controllers;

use Yii;
use common\models\Gift;
use backend\search\GiftSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Category;
use common\models\Product;
use common\models\Tag;
use yii\helpers\ArrayHelper;

/**
 * GiftController implements the CRUD actions for Gift model.
 */
class GiftController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => array_merge(Yii::$app->params['rules'], array(
                    [
                        'actions' => ['get-tag', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
            ))],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Gift models.
     * @return mixed
     */
    public function actionIndex($date_id, $rec)
    {
        $searchModel = new GiftSearch();
        $dataProvider = $searchModel->search(['id_dates' => $date_id]);

        $category = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $products = ArrayHelper::map(Product::find()->all(), 'id', 'name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => $category,
            'products' => $products,
            'date_id' => $date_id,
            'rec' => $rec // Gift Receiver id
        ]);
    }

    /**
     * Displays a single Gift model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Gift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $rec) //data id
    {
        $model = new Gift();

        if ($model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post();

            $model->id_dates = $post['id_dates'];
            $model->save();

            return $this->redirect(['gift-receiver/update', 'id' => $post['id_gift_receiver'], 'id_date' => $post['id_dates']]);
        }

        $category = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $products = ArrayHelper::map(Product::find()->all(), 'id', 'name');

        return $this->renderAjax('partials/create', [
            'model' => $model,
            'category' => $category,
            'products' => $products,
            'id_dates' => $id,
            'rec' => $rec // Gift Receiver id
        ]);
    }

    /**
     * Updates an existing Gift model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $rec)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $model->id_dates = $post['id_dates'];
            $model->save();

            return $this->redirect(['gift-receiver/update', 'id' => $post['id_gift_receiver'], 'id_date' => $post['id_dates']]);
        }

        $category = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $products = ArrayHelper::map(Product::find()->all(), 'id', 'name');

        return $this->render('partials/update', [
            'model' => $model,
            'category' => $category,
            'products' => $products,
            'id_dates' => $model->id_dates,
            'rec' => $rec // Gift Receiver id
        ]);
    }

    /**
     * Deletes an existing Gift model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $rec)
    {
        $model = $this->findModel($id);
        $id_dates = $model->id_dates;
        $this->findModel($id)->delete();

        return $this->redirect(['gift-receiver/update', 'id' => $rec, 'id_date' => $id_dates]);
    }

    public function actionGetTag($name) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tag = Tag::find()->where(['like', 'name', $name])->all();
        $results = [];
        foreach ($tag as $value) {
            $results[]=['id' => $value->name, 'name' => $value->name];
        }
        return ['results'=>$results];
    }

    /**
     * Finds the Gift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gift::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
