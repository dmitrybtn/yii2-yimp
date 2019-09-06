<?php

namespace dmitrybtn\yimp;

use yii\web\AssetBundle;

/**
 * Asset bundle for YIMP css and js files.
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@dmitrybtn/yimp/assets';

    public $css = [
        'css/yimp.css'
    ];

    public $js = [
        'js/yimp.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
        'dmitrybtn\yimp\AssetIcons',
    ];
}
