<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Api;
use app\models\Members;
use app\models\Events;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionApi()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $event = preg_replace('/[^\p{L}0-9-\s ]/iu','', Yii::$app->request->get('event'));
        $name = preg_replace('/[^\p{L}0-9-\s ]/iu','', Yii::$app->request->get('name'));
        $operation = preg_replace('/[^\p{L}0-9-\s ]/iu','', Yii::$app->request->get('operation'));
        $token = preg_replace('/[^\p{L}0-9-\s ]/iu','', Yii::$app->request->get('token'));
        $id = preg_replace('/[^\p{L}0-9-\s ]/iu','', Yii::$app->request->get('id'));
        $email = filter_var(Yii::$app->request->get('email'), FILTER_VALIDATE_EMAIL);
        if(!$email){
            return "Email не прошел валидацию";
        }
        $newObj = new Api();
        $modelApi = $newObj->getApi($event, $name, $email, $operation, $id, $token);
        return $modelApi;
    }
}