<?php


namespace dmitrybtn\yimp;

/**
 * This class is used only to make [yii\helpers\Url::normalizeRoute](https://www.yiiframework.com/doc/api/2.0/yii-helpers-baseurl#normalizeRoute()-detail)
 * public, so that [[RouteHelper]] can use it.
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class Url extends \yii\helpers\Url
{
    /**
     * Overrides [yii\helpers\BaseUrl::normalizeRoute](https://www.yiiframework.com/doc/api/2.0/yii-helpers-baseurl#normalizeRoute()-detail)
     * to make it public.
     *
     * @param $route string The route. This can be either an absolute route or a relative route.
     * @return string Normalized route suitable for UrlManager
     */
    public static function normalizeRoute($route)
    {
        return parent::normalizeRoute($route);
    }
}