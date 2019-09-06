<?php
namespace dmitrybtn\yimp\widgets\views;


use dmitrybtn\yimp\Yimp;
use Yii;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\Breadcrumbs;




/** @var Yimp $yimp */

$strMenuLeft = $yimp->menuLeft(['mode' => $yimp::MOBILE, 'options' => ['class' => 'flex-column']]);
$strMenuTop = $yimp->menuTop(['mode' => $yimp::MOBILE, 'options' => ['class' => 'navbar-nav d-none d-xl-flex ml-auto']]);
$strMenuRight = $yimp->menuRight(['mode' => $yimp::MOBILE, 'options' => ['class' => 'flex-column']])

?>

<nav class="navbar navbar-expand navbar-dark fixed-top bg-dark px-1 px-md-2 px-xl-3 py-0 py-md-2">

    <!-- Left menu toggle button -->
    <div class="navbar-icon-container d-xl-none my-auto">
        <?php if ($strMenuLeft || $strMenuTop): ?>
            <a class="navbar-brand navbar-icon navbar-icon-left fas fa-bars mx-auto" href="#"></a>
        <?php endif ?>
    </div>

    <!-- Brand for desktops -->
    <?php echo Html::a(Yii::$app->name, Url::home(), ['class' => 'navbar-brand d-none d-xl-flex']) ?>

    <!-- Brand for mobiles -->
    <?php echo $yimp->headerMobile(['class' => 'navbar-brand mx-auto d-block d-md-none']) ?>

    <!-- Breadcrumbs for desktops -->
    <?php if ($yimp->nav->crumbs !== false): ?>

        <!-- Todo: Make normal adapter? -->
        <?php foreach ($yimp->nav->crumbs as &$crumb): ?>
            <?php Html::addCssClass($crumb, 'navbar-text'); ?>
        <?php endforeach ?>

        <?php echo Breadcrumbs::widget([
            'links' => array_merge($yimp->nav->crumbs, [['label' => $yimp->nav->headerCrumb, 'class' => 'navbar-text']]),
            'options' => ['class' => 'breadcrumb bg-transparent d-none d-md-flex my-auto ml-2'],
            'homeLink' => ['label' => Yii::t('yii', 'Home'), 'url' => Yii::$app->homeUrl, 'class' => 'navbar-text'],
        ]) ?>

    <?php else: ?>
        <span class="navbar-brand d-none d-md-flex d-xl-none ml-2 my-auto py-0"><?php echo Yii::$app->name ?></span>
    <?php endif ?>

    <?php echo $strMenuTop ?>

    <!-- Right menu toggle button -->
    <div class="navbar-icon-container d-xl-none my-auto mr-0 ml-md-auto">
        <?php if ($strMenuRight): ?>
            <a class="navbar-brand navbar-icon navbar-icon-right fas fa-ellipsis-h mx-auto" href="#"></a>
        <?php endif ?>
    </div>

</nav>

<!-- Navbar imitation for correct body padding -->
<nav class="navbar navbar-expand navbar-dark px-1 px-md-2 px-xl-3 py-0 py-md-2 mb-3">
    <div class="navbar-brand fas fa-bars d-xl-none my-auto"></div>
    <div class="navbar-brand d-none d-xl-flex">&nbsp;</div>
    <div class="navbar-brand mx-auto d-block d-md-none">&nbsp;</div>
</nav>

<!-- Left and top menu for phones -->
<div class="navbar-menu navbar-menu-left bg-secondary mt-n3">
    <?php echo $strMenuLeft ?>
    <?php if ($strMenuLeft && $strMenuTop): ?>
        <hr>
    <?php endif ?>
    <?php echo $yimp->menuTop(['mode' => $yimp::MOBILE, 'options' => ['class' => 'flex-column']]); ?>
</div>

<!-- Right menu for phones -->
<div class="navbar-menu navbar-menu-right bg-secondary mt-n3">
    <?php echo $strMenuRight ?>
</div>

