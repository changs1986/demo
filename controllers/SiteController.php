<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\models\Supplier;
use app\models\LoginForm;
use app\models\SearchForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

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
        $instance = Supplier::find();

        $model = new SearchForm;
        $model->load(Yii::$app->request->get(), 'SearchForm');
        if (!empty($model->operation) && !empty($model->id)) {
            $instance = $instance->where([$model->operation, "id", $model->id]);
        }
        if (!empty($model->name)) {
            $instance = $instance->where(["like", "name", $model->name]);
        }
        if (!empty($model->code)) {
            $instance = $instance->where(["like", "code", $model->code]);
        }
        if (!empty($model->t_status)) {
            $instance = $instance->where(["=", "t_status", strtolower($model->t_status)]);
        }
        return $this->render('index', [
            'dataProvider' =>  new ActiveDataProvider([
                'query' => $instance,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            'model' => $model,
        ]);
    }
    /**
     * export action.
     *
     * @return none
     */
    public function actionExport()
    {
        $downAll = Yii::$app->request->get("all");
        $instance = Supplier::find();
        if ($downAll == 1) {
            $data = $instance->all();
        } else {
            $id = array_filter(explode(",", Yii::$app->request->get("id")));
            if (!empty($id)) {
                $data = $instance->where(['in', 'id', $id])->all();
            }
        }
        $fileName = time() . '.csv';
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$fileName);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        ob_start();
        echo chr(0xEF).chr(0xBB).chr(0xBF); //解决乱码
        echo sprintf("%s,%s,%s,%s\n", "id", "name", "code", "t_status");
        if (!empty($data)) {
            foreach ($data as $v) {
                echo sprintf("%s,%s,%s,%s\n", $v->id, $v->name, $v->code, $v->t_status);
                ob_get_contents();
            }
        }
        ob_flush();
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
}
