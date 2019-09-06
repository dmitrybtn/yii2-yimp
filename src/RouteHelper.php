<?php

namespace dmitrybtn\yimp;

use yii\helpers\ArrayHelper;

/**
 * Provides methods to work with routes
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class RouteHelper
{

    /**
     * Checks if route matches the mask
     *
     * Route and mask are exploded by `/` delimiter and then compared part by part. Mask can be one of the following:
     *
     * 1. `site/index` mask matches only `site/index` route
     * 1. `site/login|logout` mask matches only `site/login` and `site/logout` routes
     * 1. `site/*` matches every route, beginning with `site/`
     *
     * @param string $mask Mask for checking
     * @param string $route Route to be checked
	 * 
     * @return bool Whether route matches mask
     */
	public static function match($mask, $route)
	{
		$sttRoute = explode('/', trim($route, '/'));
		$sttMask = explode('/', trim($mask, '/'));

		foreach ($sttMask as $k => $vMask) {
			
			$vRoute = ArrayHelper::remove($sttRoute, $k);
			
			if ($vMask == '*') {
				if (array_key_exists($k + 1, $sttMask)) continue;
				else return true;
			}

			if (!in_array($vRoute, explode('|', $vMask))) {
				return false;
			}
		}

		return count($sttRoute) == 0;
	}

    /**
     * Overrides [yii\helpers\BaseUrl::normalizeRoute](https://www.yiiframework.com/doc/api/2.0/yii-helpers-baseurl#normalizeRoute()-detail)
     * to make it public.
     *
     * @param $route string The route. This can be either an absolute route or a relative route.
     * @return string Normalized route suitable for UrlManager
     */
    public static function normalize($route)
    {
        return Url::normalizeRoute($route);
    }
}

