<?php


namespace dmitrybtn\yimp\widgets;


use Yii;
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
     * @var string Title, rendered at the top of widget.
     */
    public $title;

    /**
     * @var string Url, rendered as `href` attribute of `Cancel` button. If false, `Cancel` button will not be rendered.
     */
    public $cancelUrl = false;

    /**
     * Controls constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->title = Yii::t('yimp', 'Options');

        parent::__construct($config);
    }

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