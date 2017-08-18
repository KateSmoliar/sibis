<?php


namespace app\models;
use yii\db\ActiveRecord;


class MessageForm extends ActiveRecord
{

//    public $name;
//    public $homepage;
//    public $captcha;

//$userHost = Yii::$app->request->userHost;



    public static function tableName()

    {
        return 'messages';
    }

    public function rules()
    {
        return[
          [['user_name','email', 'captcha', 'text'], 'required' ]  ,
          //  ['name', 'format' => '^[a-zA-Z0-9]+$'],
            ['email', 'email'],
//            ['home_page', 'url', 'defaultScheme' => 'http'],
           ['captcha', 'captcha'],
           ['user_name', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/'],
          ['home_page' ,  'url', 'defaultScheme' => 'http'],

            [['user_name','email','captcha' ,'home_page' ,'captcha' ,'text'],'filter','filter'=>'\yii\helpers\HtmlPurifier::process']
        ];
    }
}