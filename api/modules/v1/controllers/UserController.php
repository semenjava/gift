<?php

namespace app\modules\v1\controllers;

//UserSearch error
use app\modules\v1\components\ActiveController;
use common\models\User;
use backend\search\UserSearch;
use common\components\HttpStatusCodes;
use yii\helpers\ArrayHelper;
use app\models\LoginForm;

use yii\web\UnauthorizedHttpException;
use yii\filters\auth\HttpBearerAuth;

class UserController extends ActiveController {

    /**
     *
     * @var type
     */
    public $modelClass = 'common\models\User';

    /**
     *
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
        $behaviors['authenticator']['except'] = ['login', 'create', 'signup-player', 'reset', 'check-version', 'upload-video', 'check-facebook-token'];
        return $behaviors;
    }

    /**
     * covered with LoginCept
     *
     * @return array
     */
    public function actionLogin() {
        $model = new LoginForm();
        if (!$model->load(\Yii::$app->request->post()) || !$model->login()) {
            throw new \yii\web\UnauthorizedHttpException('Authorisation Error');
        }

        return $this->responseSuccess([
            'access_token' => User::generateAccessToken(),
            'id' => \Yii::$app->user->id
        ]);
    }


    public function actionCreate() {
        $model = new User();
        return $this->responseSave($model);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        return $this->responseSave($model);
    }

    /**
     * covered with ResetPasswordCept
     *
     * @return array
     */
    public function actionReset() {
        $arr = [
            'error' => [
                'code' => '401',
                'message' => 'Not found'
            ]
        ];
        $model = new \frontend\models\PasswordResetRequestForm();
        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->sendEmail(true)) {
                    $arr = [
                        'text' => \Yii::t('app', 'Check your email for further instructions.')
                    ];
                } else {
                    $arr['error']['code'] = '200';
                    $arr['error']['message'] = \Yii::t('app', 'Sorry, we are unable to reset password for email provided.');
                }
            } else {
                $arr = [
                    'error' => [
                        'code' => '200',
                        'message' => $model->getErrors('email')[0]
                    ]
                ];
            }
        }
        return $arr;
    }

    /**
     *
     * covered with GetUser
     *
     * @param int $id
     * @return type
     */
    public function actionGet($id) {
        $user = User::getUserById($id);
        if ($user) {
            return $this->responseSuccess(ArrayHelper::toArray($user));
        }
        return $this->responseFail($user);
    }

    /**
     *
     * covered with SearchCept
     *
     * @param integer $id player id
     * @return array
     */
    public function actionSearch($id) {

        $model = \common\models\User::findIdentity($id);
        $result = [
            'error' => [
                'code' => '401',
                'message' => 'Not found'
            ]
        ];
        if ($model) {
            $result = [];
        }

        return $result;
    }

    /**
     *
     * covered with CheckAccessTokenCept
     *
     * @return array|null
     */
    public function actionCheckAccessToken() {
        $post = \Yii::$app->request->post();
        $tokenData = \Yii::$app->db->createCommand(
                        "SELECT * FROM access_token WHERE token = '" . $post['access_token'] . "'"
                )->queryOne();
        if (empty($tokenData)) {
            return ['error' => ['message' => '']];
        }
        $now = (new \DateTime())->setTimezone(new \DateTimeZone("UTC"))->format(\common\components\DateUtils::FORMAT_DEFAULT);
        $tokenTtlDate = date(\common\components\DateUtils::FORMAT_DEFAULT, strtotime($tokenData['created']) + $tokenData['ttl']);
        if ($tokenTtlDate < $now) {
            return ['error' => ['message' => '']];
        }
        if ($tokenData['id_user'] != $post['id']) {
            return ['error' => ['message' => '']];
        }

        $response = [
            'error' => [
                'code' => '404',
                'message' => 'Not Found'
            ]
        ];
        $user = User::findIdentity($tokenData['id_user']);
        if (empty($user)) {
            return $response;
        }

        \Yii::$app->user->setIdentity($user);
        if (User::ID_DND != $tokenData['id_user']) {
            $userRole = User::getUserRoleById($tokenData['id_user']);
            switch ($userRole) {
                case User::USER_ROLE_PLAYER:
                    $response = ['user' => \common\models\User::getUserBaseInfo($tokenData['id_user'])];
                    break;
                case User::USER_ROLE_EVALUATOR:
                case User::USER_ROLE_SCOUT:
                    $response = ['user' => \common\models\User::getEvaluatorBaseInfo($tokenData['id_user'])];
                    break;
            }
        }
        return $response;
    }

    /**
     *
     * covered with CheckAccessTokenCept
     *
     * @return array|null
     */
    public function actionCheckFacebookToken() {
        $post = \Yii::$app->request->post();
        $response = [
            'error' => [
                'code' => '404',
                'message' => 'User not Found'
            ]
        ];

        $userByFacebookToken = \common\components\UserHelper::createByToken($post);
        if (empty($userByFacebookToken)) {
            return [
                'error' => [
                    'code' => HttpStatusCodes::INVALID_TOKEN,
                    'message' => 'User not Found'
                ]
            ];
        }

        if (!empty($userByFacebookToken)) {
            if ($userByFacebookToken->hasErrors('email')) {
                $response['error']['message'] = $userByFacebookToken->getErrors('email')[0];
                return $response;
            } elseif ($userByFacebookToken->hasErrors('username')) {
                $response['error']['message'] = $userByFacebookToken->getErrors('username')[0];
                return $response;
            }
            $user = User::findIdentity($userByFacebookToken['id']);
        }
        if (empty($user)) {
            return $response;
        }

        \Yii::$app->user->setIdentity($user);
        if (User::ID_DND != $user['id']) {
            $accessToken = User::generateAccessToken();
            $userRole = User::getUserRoleById($user['id']);
            switch ($userRole) {
                case User::USER_ROLE_PLAYER:
                    $response = ['user' => \common\models\User::getUserBaseInfo($user['id'])];
                    break;
                case User::USER_ROLE_EVALUATOR:
                case User::USER_ROLE_SCOUT:
                    $response = ['user' => \common\models\User::getEvaluatorBaseInfo($user['id'])];
                    break;
            }
            $response['user']['access_token'] = $accessToken;
        }
        return $response;
    }

    /**
     * covered with ChangePasswordCept
     *
     * @param int $id
     * @return array
     */
    public function actionChangePassword($id) {
        $result = [
            'error' => [
                'code' => '401',
                'message' => 'Not found'
            ]
        ];
        $user = \common\models\User::findIdentity($id);
        if (empty($user)) {
            return $result;
        }
        if ($user && \Yii::$app->request->isPost) {
            if ($user->validatePassword(\Yii::$app->request->post('password_old'))) {
                if (strlen(\Yii::$app->request->post('password_new')) >= 6) {
                    $user->setPassword(\Yii::$app->request->post('password_new'));
                    if ($user->save(true, ['password_hash'])) {
                        $result = ['user' => \common\models\User::getUserBaseInfo($id)];
                    } else {
                        $result['error']['code'] = '200';
                        $result['error']['message'] = \Yii::t('app', 'Save failed.');
                    }
                } else {
                    $result['error']['code'] = '200';
                    $result['error']['message'] = \Yii::t('app', 'Password should contain at least 6 characters.');
                }
            } else {
                $result['error']['code'] = '200';
                $result['error']['message'] = \Yii::t('app', 'Current password is incorrect.');
            }
        }
        return $result;
    }

    /**
     *
     * covered with CheckVersionCept
     *
     * @param string $v
     * @return array
     */
    public function actionCheckVersion($v) {
        if (empty($v)) {
            return ['update_available' => 0];
        }
        $version = explode('.', $v);
        $settings = \common\models\Settings::getInstance();
        $currentVersion = explode('.', $settings->mobile_app_version);
        foreach (array_keys($version) as $key) {
            if ((int) $currentVersion[$key] > (int) $version[$key]) {
                return ['update_available' => 1];
            } elseif ((int) $version[$key] > (int) $currentVersion[$key]) {
                return ['update_available' => 0];
            }
        }
        return ['update_available' => 0];
    }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

}
