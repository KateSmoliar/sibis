<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <script language="JavaScript">
                window.location.href = "<?= Yii::$app->urlManager->createUrl(['site/messages'])?>"
    </script>

    </div>

