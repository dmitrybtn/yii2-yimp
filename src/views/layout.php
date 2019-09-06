<?php

use dmitrybtn\yimp\widgets\Alert;
use dmitrybtn\yimp\Yimp;
use yii\bootstrap4\Html;

$yimp = new Yimp();
$yimp->register($this);

/** @var string $content Content came from view */

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php echo Html::csrfMetaTags() ?>

        <title><?php echo Html::encode($yimp->nav->getTitle()) ?></title>

        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

            <?php echo $yimp->navbar() ?>

            <?php echo $yimp->beginSidebars() ?>
                <?php echo $yimp->beginLeftSidebar() ?>

                        <?php echo $yimp->beginLeftSidebarMenu() ?>
                            <?php echo $yimp->menuLeft([
                                'options' => ['class' => 'nav-pills flex-column border rounded py-2']
                            ]) ?>
                        <?php echo $yimp->endLeftSidebarMenu() ?>

                        <?php if (isset($this->blocks[$yimp::SIDEBAR_LEFT])): ?>
                            <?php echo $this->blocks[$yimp::SIDEBAR_LEFT] ?>
                        <?php endif ?>

                <?php echo $yimp->endLeftSidebar() ?>
                <?php echo $yimp->beginRightSidebar() ?>

                        <?php echo $yimp->beginRightSidebarMenu() ?>
                            <?php echo $yimp->menuRight([
                                'options' => ['class' => 'nav-pills flex-column border rounded py-2']
                            ]) ?>
                        <?php echo $yimp->endRightSidebarMenu() ?>

                        <?php if (isset($this->blocks[$yimp::SIDEBAR_RIGHT])): ?>
                            <?php echo $this->blocks[$yimp::SIDEBAR_RIGHT] ?>
                        <?php endif ?>

                <?php echo $yimp->endRightSidebar() ?>
            <?php echo $yimp->endSidebars() ?>

            <?php echo $yimp->beginContent() ?>
                <?php echo $yimp->headerDesktop() ?>

                <?php echo Alert::widget() ?>

                <?php echo $content ?>
            <?php echo $yimp->endContent() ?>

            <?php if (isset($this->blocks[$yimp::FOOTER])): ?>
                    <?php echo $this->blocks[$yimp::FOOTER] ?>
            <?php endif ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>