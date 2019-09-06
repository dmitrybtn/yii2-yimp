<?php

namespace dmitrybtn\yimp;

use yii\web\AssetBundle;

/**
 * Asset bundle for Fontawesome.
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class AssetIcons extends AssetBundle
{
    public $sourcePath = '@bower/fontawesome';

    public $css = [
        'css/all.css',
    ];

    public $publishOptions = [
        'only' => [
            'css/*',
            'webfonts/*',
        ]
    ];
}
