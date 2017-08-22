<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
//use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MessageForm;
use yii\data\Pagination;
use app\models\Messages;
use yii\helpers\html;
use yii\db\Connection;

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
//                'class' => 'yii\captcha\CaptchaAction',
                'class' => 'yii\captcha\MyCaptcha',
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

        $user_name = Html::encode($_POST['MessageForm']['user_name']);
        $email = Html::encode($_POST['MessageForm']['email']);
        $home_page = Html::encode($_POST['MessageForm']['home_page']);
        $text = Html::encode($_POST['MessageForm']['text']);
        $captcha = Html::encode($_POST['MessageForm']['captcha']);



        if ($_POST)
            {
                Yii::$app->db->createCommand()->insert('messages', [
                'user_name' => $user_name,
                'email' => $email,
                'home_page'=>$home_page,
                'text'=>$text,
                'captcha'=>$captcha,
                'date_time'=>$form->date_time,
                'ip'=>$form->ip,
                'browser'=>$form->browser,


])->execute();
                Yii::$app->session->setFlash('success' , 'Your message has been successfully added to DB');

            }




        return $this->render('messages',
            [   'form' => $form,
                'user_name' => $user_name,
                'email' => $email,
                'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                    'user_name' => $user_name,


    ],
            ]);
    }


    public function actionGetMessages()
    {
        $messages =  Yii::$app->db->createCommand('SELECT * FROM messages')
            ->queryAll();
        $messages_load =   Yii::$app->db->createCommand('SELECT * FROM messages')
            ->queryAll();


        $pagination = new Pagination(
            [
                'defaultPageSize' => 25,
                'totalCount'=> Yii::$app->db->createCommand('SELECT COUNT(*) FROM messages')
                    ->queryScalar(),
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

        $sql = 'SELECT * FROM `messages`  order by '.$sortBy.' '.$or.'  limit '.$pagination->limit.' offset '.$pagination->offset;
        $messages = Yii::$app->db->createCommand
        ($sql)
            ->queryAll();


            $sql = $sql = 'SELECT * FROM `messages`  order by '.$sortBy.' '.$or;
            $messages_load =  Yii::$app->db->createCommand
            ($sql)
                ->queryAll();

        }

        else
        {
            $sql = 'SELECT * FROM `messages`  order by `date_time` desc limit '.$pagination->limit.' offset '.$pagination->offset;
            $messages = Yii::$app->db->createCommand
            ($sql)
                ->queryAll();




            $messages_load = Yii::$app->db->createCommand  ('SELECT * FROM `messages`  order By `date_time` desc')
                ->queryAll();
        }


        if (Yii::$app->request->get('del'))
        {
            $del_id = 'id = '.Yii::$app->request->get('del');
            $post = Yii::$app->db->createCommand()->delete('messages', $del_id)->execute();



        }

        //       get delete url
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if (Yii::$app->request->get('del'))
        {


            $url = str_replace( '&del='.Yii::$app->request->get('del'), '',  $url);
            ?>
            <script language="JavaScript">
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
            'messages_load'=>$messages_load,
            'pagination'=>$pagination,
//            'name'=> yii::$app->session->get('name'),
        'url'=>$url,
            'ulr'=>$ulr,
            'first_url'=>$first_url,
            'second_url'=>$second_url
        ] );



    }


}
