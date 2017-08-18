<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MessageForm;
use yii\data\Pagination;
use app\models\Messages;
use yii\helpers\html;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
     * @return string
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
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


    public function actionMessages()
    {
        $form = new MessageForm();

        $user_agent = $_SERVER["HTTP_USER_AGENT"];
        if (strpos($user_agent, "Firefox") !== false)  $form->browser = "Firefox";
        elseif (strpos($user_agent, "Opera") !== false) $form->browser = "Opera";
        elseif (strpos($user_agent, "Chrome") !== false) $form->browser = "Chrome";
        elseif (strpos($user_agent, "MSIE") !== false) $form->browser = "Internet Explorer";
        elseif (strpos($user_agent, "Safari") !== false) $form->browser = "Safari";
        else $form->browser = "Unknown";
        $form->date_time = date('Y-m-d H:i:s');


        $form->ip =  Yii::$app->request->userIP;

        if ($form->load(Yii::$app->request->post())) {

            if ($form->save())
            {
                Yii::$app->session->setFlash('success' , 'ok');
                return $this->refresh();
              ?>
                <script>
            alert("Your message successfully add");
                </script>
<?php

            }
            else
            {
                Yii::$app->session->setFlash('error', 'error');
            }
            $user_name = Html::encode($form->user_name);
            $email = Html::encode($form->email);


        } else {
            $user_name = '';
            $email = '';
        }

        return $this->render('messages',
            ['form' => $form,
                'user_name' => $user_name,
                'email' => $email,
                 'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
    ],
            ]);
    }


    public function actionGetMessages()
    {
        $messages = Messages::find();


        $pagination = new Pagination(
            [
                'defaultPageSize' => 25,
                'totalCount'=> $messages->count()
            ]
        );

        switch(Yii::$app->request->get('chose'))
        {
            case 'user_name': $sortBy = 'user_name';
                break;
            case 'email': $sortBy = 'email';
                break;
            case 'date_time': $sortBy = 'date_time';
                break;
            case 'text': $sortBy = 'text';
                break;

        }



        if (Yii::$app->request->get('order'))
        {

            $or = Yii::$app->request->get('order');


        $messages = $messages->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy("$sortBy $or")
            ->all();


        }

        else
        {
            $messages = $messages->offset($pagination->offset)
                ->limit($pagination->limit)
                ->orderBy('date_time desc')
                ->all();
        }


        if (Yii::$app->request->get('del'))
        {
            $post = Messages::findOne(Yii::$app->request->get('del'));
            $post->delete();

        }

        //       get delete url
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if (Yii::$app->request->get('del'))
        {


            $url = str_replace( '&del='.Yii::$app->request->get('del'), '',  $url);
            ?>
            <script language="JavaScript">
                //                alert("Информация добавлена в базу");
                window.location.href = "<?= $url ?>"
            </script>
            <?php

        }

        if(!Yii::$app->request->get('del'))
        {

            $ulr =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $findme = '?';
            $pos = strpos($ulr, $findme);
            if ($pos === false) {


                $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?del=' ;

            }
            else
            {
                $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&del=' ;
            }
        }
        else
        {


            $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&del=' ;
        }
//=======================================================================================================

// looking if we already have some column to sort

        $ulr =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $findme   = 'chose';
        $pos = strpos($ulr, $findme);

        if ($pos === false) {
            $findme = '?';
            $pos = strpos($ulr, $findme);
            if ($pos === false) {

                $ulr = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?order=asc&chose=';
                $first_url = $ulr;
            }

            else {
                $ulr = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&order=asc&chose=';
                $first_url = $ulr;


            }
        }
        else
        {
            $chose_change = $_GET['chose'];
            $ulr = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $ulr = str_replace( $chose_change,'', $ulr);
            if (isset($_GET['order']))
            {
                $ask_change = $_GET['order'];

                if ($ask_change != "desc")
                {

                    $ulr = str_replace( "asc","desc", $ulr);

                }
                else
                {
                    $ulr = str_replace("desc", "asc", $ulr);
                }
            }
            $pos = strpos($ulr, 'chose');
            $url_len = strlen($ulr);
            $first_url = substr($ulr, 0, $pos+6);
            $second_url = substr($ulr, $pos+6);

        }
//=========================================================================================
        return $this->render('get-messages' ,[
            'messages'=>$messages,
            'pagination'=>$pagination,
//            'name'=> yii::$app->session->get('name'),
        'url'=>$url,
            'ulr'=>$ulr,
            'first_url'=>$first_url,
            'second_url'=>$second_url
        ] );



    }


}
