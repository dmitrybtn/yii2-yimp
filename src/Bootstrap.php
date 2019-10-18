<?php


namespace dmitrybtn\yimp;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['yimp'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@dmitrybtn/yimp/messages',
        ];
    }
}