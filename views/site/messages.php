<?php

use yii\widgets\ActiveForm;
use yii\helpers\html;

use yii\captcha\Captcha;
?>


<?php $f = ActiveForm::begin();?>

<!---->
<!---->
<?php //$form = ActiveForm::begin([ 'id' => 'form', 'method' => 'POST',
//    'action' => 'action.php',
//    'options' => ['style' => 'width: 100%;', 'autocomplete' => 'off']
//]);?>
    <div class = " col-lg-6 col-md-6 col-sm-6 col-xs-6" >
<?= $f->field($form, 'user_name')?>
<?= $f->field($form, 'email')?>
<?= $f->field($form, 'home_page')?>

<?= $f->field($form, 'captcha')->widget(Captcha::className()) ?>
<?= $f->field($form, 'text')?>
<?= html::submitButton('Send'); ?>

<?php $f = ActiveForm::end();?>

        </div>
