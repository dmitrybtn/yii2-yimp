<?php


namespace dmitrybtn\yimp\widgets;


use yii\bootstrap4\Widget;

/**
 * Widget, showing form `Submit` and `Cancel` buttons is right sidebar on desktops and in footer on mobiles.
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class Controls extends Widget
{
    /**
     * @var string Form `id` selector, rendered as `form` attribute of `Submit` button.
     */
    public $form;


    /**
     * @var string Url, rendered as `href` attribute of `Cancel` button.
     */
    public $cancelUrl;

    /**
     * Runs widget
     *
     * @return string
     */
    public function run()
    {
        return $this->render('controls');
    }
}