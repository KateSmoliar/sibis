<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<div class = "row ">
    <div class = " col-lg-2 col-md-2 col-sm-2 col-xs-2" >

        <ul class="navmenu navmenu-default nav">


            <li class = 'test'><a href='<?= Yii::$app->urlManager->createUrl(['site/messages'])?>'>Leave message</a></li>
            <li><a href='<?=Yii::$app->urlManager->createUrl("site/get-messages")?>'>Messages</a></li>

        </ul>

    </div>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
