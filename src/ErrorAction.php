<?php

namespace dmitrybtn\yimp;

/**
 * Error action, showing error info using [[Navigator]].
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class ErrorAction extends \yii\web\ErrorAction
{
	public $view = '@dmitrybtn/yimp/views/error';

    public function run()
    {
        if ($this->controller->canGetProperty('nav')) {
            $this->controller->nav->title = $this->getExceptionName();
            $this->controller->nav->crumbs = false;
        }

        return parent::run();
	}
}
