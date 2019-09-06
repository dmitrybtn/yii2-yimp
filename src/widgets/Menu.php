<?php


namespace dmitrybtn\yimp\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\helpers\ArrayHelper;

/**
 * Extension of [yii\bootstrap4\Nav](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/api/2.0/yii-bootstrap4-nav),
 * providing some additional functionality.
 *
 * The following functionality is provided:
 *
 * 1. Generate item as a `<span>` tag if it's `url` property is not set.
 * 1. Config default HTML attributes for all items.
 *
 * @property bool $visible Whether whole menu is visible
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class Menu extends Nav
{
    /**
     * @var array The HTML attributes, used if item `linkOptions` is not set.
     */
    public $linkOptions = [];

    /**
     * Overrides [yii\bootstrap4\Nav::renderItem](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/api/2.0/yii-bootstrap4-nav#renderItem()-detail)
     * to work with items with empty url.
     *
     * @param array|string $sttItem
     * @return array|string
     * @throws InvalidConfigException
     */
    public function renderItem($sttItem)
    {
        if (is_string($sttItem)) {
            return $sttItem;
        }

        if (!isset($sttItem['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }

        $sttItem['linkOptions'] = ArrayHelper::remove($sttItem, 'linkOptions', $this->linkOptions);

        if (!isset($sttItem['url']) && !isset($sttItem['items'])) {

            $encodeLabel = isset($sttItem['encode']) ? $sttItem['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($sttItem['label']) : $sttItem['label'];
            $options = ArrayHelper::getValue($sttItem, 'options', []);
            $linkOptions = ArrayHelper::getValue($sttItem, 'linkOptions', $this->linkOptions);

            Html::addCssClass($options, 'nav-item');
            Html::addCssClass($linkOptions, 'nav-link');

            return Html::tag('li', Html::tag('span', $label, $linkOptions), $options);
        }

        return parent::renderItem($sttItem);

    }
}