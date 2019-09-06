<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\bootstrap4\Html;

?>

<div class="alert alert-danger">
    <?= nl2br(Html::encode($message)) ?>
</div>

<?php if ($objReferrer = Yii::$app->request->referrer): ?>
    <p>Попробуйте <?php echo Html::a('вернуться назад', Yii::$app->request->referrer) ?> и все исправить.</p>
<?php endif ?>
