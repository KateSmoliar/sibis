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
<div id = 'errorBlock'></div>

<?= $f->field($form, 'email')?>
<div id = 'errorBlock-email'></div>

<?= $f->field($form, 'home_page')?>
<div id = 'errorBlock-home_page'></div>

<?= $f->field($form, 'captcha')->widget(Captcha::className()) ?>
<?= $f->field($form, 'text')?>
        <?= Html::submitButton('<span  aria-hidden="true"> Send</span>', ['id' => 'my']) ?>

<?php $f = ActiveForm::end();?>

        </div>



    <script src = '/js/validate.js'>

    </script>
<?php
 if (Yii::$app->session->hasFlash('success')){ ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i>Saved!</h4>
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php }
?>
