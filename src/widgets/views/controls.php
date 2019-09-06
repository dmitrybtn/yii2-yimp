<?php

use dmitrybtn\yimp\Yimp;
use yii\bootstrap4\Html;

?>



<!-- Опции для десктопов -->
<?php $this->beginBlock(Yimp::SIDEBAR_RIGHT); ?>
    <div class="sidebar-form-controls border rounded p-3">
        <div class="h5">Options</div>
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success btn-block', 'form' => $this->context->form->id]) ?>
        <?php echo Html::a('Cancel', $this->context->cancelUrl, ['class' => 'btn btn-outline-secondary btn-block']) ?>
    </div>
<?php $this->endBlock(); ?>


<!-- Опции для телефонов -->
<?php $this->beginBlock(Yimp::FOOTER); ?>

    <footer class="container-fluid fixed-bottom py-2 bg-light d-xl-none">
        <div class="row justify-content-center">
            <div class="col-6 col-md-5"><?php echo Html::a('Cancel', $this->context->cancelUrl, ['class' => 'btn btn-block btn-secondary']) ?></div>
            <div class="col-6 col-md-5"><?php echo Html::submitButton('Save', ['class' => 'btn btn-block btn-success', 'form' => $this->context->form->id]) ?></div>
        </div>
    </footer>

<?php $this->endBlock(); ?>


