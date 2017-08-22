<?php


namespace app\models;
use yii\base\Model;


class MessageForm extends Model
{

    public $user_name;
    public $homepage;
    public $captcha;
    public $browser;
    public $date_time;
    public $ip;
    public $email;
    public $home_page;
    public $text;


    public static function tableName()

    {
        return 'messages';
    }



    public function rules()
    {
        return[
//            [['user_name','email', 'captcha', 'text'], 'required' ]  ,
//            ['email', 'email'],
            ['captcha', 'captcha'],
//            ['user_name', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/'],
//            ['home_page' ,  'url', 'defaultScheme' => 'http'],
//            [['user_name','email','captcha' ,'home_page' ,'captcha' ,'text'],'filter','filter'=>'\yii\helpers\HtmlPurifier::process']

        ];
    }

}