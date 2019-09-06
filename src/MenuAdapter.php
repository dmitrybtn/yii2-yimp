<?php

namespace dmitrybtn\yimp;

use dmitrybtn\yimp\widgets\Menu;
use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

/**
 * Adapter for [yii\bootstrap4\Nav](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/api/2.0/yii-bootstrap4-nav),
 * providing some additional functionality.
 *
 * The following functionality is provided:
 *
 * 1. Configure items visibility for desktops and mobiles separately.
 * 1. Generate an empty string if menu is invisible. Menu is invisible on current device if all link items are invisible
 *    on this device, even if there are visible labels (items with empty 'url' property).
 *
 * Config array, passed to [[MenuAdapter::widget]] differs from the original in the following:
 *
 * - `mode`: YIMP renders each menu in layout two times - for desktops and for mobile devices. In first case it sets this
 *    prop to [[Yimp::DESKTOP]], in second - to [[Yimp::MOBILE]]. If item's `visibleMode` prop is set, this item will be
 *    rendered only if it's `visibleMode` value equals to this one.
 *
 * - `items`:
 *
 *     - `active`: In original widget it is bool. Here it can be string, representing the mask, passed to [[RouteHelper::match]]. If current route matches
 *       this mask, item will be activated. For example, this property is set to `orders/*`, item will be active on
 *       `orders/create`, `orders/update`, `orders/item/create`, and so on.
 *     - `visibleMode`: If you want to show menu item only on desktops, set it to `Yimp::DESKTOP`. For mobiles - `YIMP::MOBILE`.
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class MenuAdapter extends BaseObject
{
    /**
     * @var bool Whether all menu is visible
     */
    protected $visible = false;


    /**
     * @var string Current route
     */
    protected $route;


    /**
     * @var string Mode for display menu. Can be Yimp::DESKTOP or Yimp::MOBILE
     */
    protected $mode;


    /**
     * Creates Bootstrap Nav widget instance and renders it.
     *
     * @param array $config Config array to be adapted for Bootstrap Nav widget.
     *
     * @return string
     * @throws \Exception
     */
    public function widget($config = []): string
    {
        $this->visible = false;
        $this->mode = ArrayHelper::remove($config, 'mode', Yimp::DESKTOP);
        $this->route = ArrayHelper::remove($config, 'route');

        if ($this->route === null) {
            $this->route = Yii::$app->controller->route;
        }

        $config['items'] = $this->adapt($config['items']);

        if ($this->visible) {
            return Menu::widget($config);
        } else {
            return '';
        }
    }

    /**
     * Adapts menu items to Bootstrap Nav widget format.
     *
     * @param $items array List of menu items
     * @return array List of adapted menu items
     */
    protected function adapt($items)
    {
        foreach ($items as &$item) {
            $item = $this->adaptItem($item);

            if (isset($item['items'])) {
                $item['items'] = $this->adapt($item['items']);
            }

            if (isset($item['url']) && $item['visible']) {
                $this->visible = true;
            }
        }

        return $items;
    }


    /**
     * Adapts menu item to Bootstrap Nav widget format.
     *
     * @param $item array Menu item config
     * @return array Adapted menu item config
     */
    protected function adaptItem($item)
    {
        // Activate item if current route matches mask in 'active' attribute
        if (is_string(ArrayHelper::getValue($item, 'active'))) {
            $item['active'] = RouteHelper::match($item['active'], $this->route);
        }

        // Set visible property according to its 'visibleMode' attribute
        $visible = ArrayHelper::getValue($item, 'visible', true);

        if (isset($item['visibleMode']) && $this->mode !== null) {
            $visible = $visible && ($item['visibleMode'] == $this->mode);
        }

        $item['visible'] = $visible;

        return $item;
    }
}