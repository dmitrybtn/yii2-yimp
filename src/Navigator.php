<?php


namespace dmitrybtn\yimp;


use Yii;
use yii\base\BaseObject;

/**
 * Base class to pass data from controller to layout.
 *
 * Navigator has the following properties, used in layout:
 *
 * - `brand`: Application name, displayed as brand label in navbar. It is `Yii::$app->name` by default.
 * - `title`: Page name, displayed as `<title>` tag. It is `ucfirst(Yii::$app->controller->action->id)` by default. This property
 *   is also used as default value for `header`, `headerMobile`, and `headerCrumb` properties.
 * - `headerDesktop`: Page name, displayed as `<h1>` on desktops. If false, `<h1>` will not be displayed.
 * - `headerMobile`: Page name, displayed in navbar on mobiles.
 * - `headerCrumb`: Last part of breadcrumbs, representing current page title. If false, it will not be displayed.
 * - `menuLeft`: left menu config, represented by [yii\bootstrap4\Nav::items](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/api/2.0/yii-bootstrap4-nav)
 *   with additional functionality, provided by [[MenuAdapter]].
 * - `menuRight`: right menu config, represented by [yii\bootstrap4\Nav::items](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/api/2.0/yii-bootstrap4-nav)
 *   with additional functionality, provided by [[MenuAdapter]].
 * - `menuTop`: top menu config, represented by [yii\bootstrap4\Nav::items](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/api/2.0/yii-bootstrap4-nav)
 *   with additional functionality, provided by [[MenuAdapter]].
 * - `crumbs`: Breadcrumbs config, represented by [yii\bootstrap4\Breadcrumbs::links](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/api/2.0/yii-bootstrap4-breadcrumbs) property,
 *   without last item, which is taken from `headerCrumb` property.
 *
 *
 * @property string $brand
 * @property string $title
 * @property string $headerMobile
 * @property string|false $headerDesktop
 * @property string|false $headerCrumb
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class Navigator extends BaseObject
{
    protected $_brand;
    protected $_title;
    protected $_headerDesktop;
    protected $_headerMobile;
    protected $_headerCrumb;

    /**
     * @var array|false Breadcrumbs config, passed to [Breadcrumbs]() widget.
     *
     * If it is `false`, breadcrumbs will not be rendered.
     *
     */
    public $crumbs = [];

    /**
     * @var array Left menu config
     *
     * Left menu is rendered in left sidebar on desktops and in left slider on mobiles. It is adapted by [[MenuAdapter]]
     * and rendered by [[widgets\Menu]]. It is recommended to use left menu as main menu of your application and config
     * it in your implementation of [[Navigator]] class.
     */
    public $menuLeft = [];

    /**
     * @var array Right
     *
     * Right menu is rendered in right sidebar on desktops and in right slider on mobiles. It is adapted by [[MenuAdapter]]
     * and rendered by [[widgets\Menu]]. It is recommended to use it as context menu and config it in actions.
     */
    public $menuRight = [];

    /**
     * @var array Left menu config, rendered by [[MenuAdapter]].
     *
     * Top menu is rendered in navbar on desktops and in left slider (after left menu) on mobiles. It is adapted by [[MenuAdapter]]
     * and rendered by [[widgets\Menu]]. It is recommended to use it to user-specific options (Login, Logout, Profile
     * settings and others) and configure it in your implementation of [[Navigator]] class.
     */
    public $menuTop = [];


    /**
     * Getter for `brand` property
     *
     * If `brand` property was not set by [[setBrand]], `Yii::$app->name` will be returned.
     *
     * @return string Brand label
     */
    public function getBrand(): string
    {
        if ($this->_brand === null) {
            return Yii::$app->name;
        }

        return $this->_brand;
    }

    /**
     * Setter fot `brand` property
     *
     * @param string $brand
     */
    public function setBrand(string $brand): void
    {
        $this->_brand = $brand;
    }

    /**
     * Getter for `title` property, used to render `<title>` tag.
     *
     * If `title` property was not set by [[setTitle]], current action index will be returned.
     *
     * @return string Page title
     */
    public function getTitle()
    {
        if ($this->_title === null) {
            return ucfirst(Yii::$app->controller->action->id);
        }

        return $this->_title;
    }

    /**
     * Setter fot `title` property
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->_title = $title;
    }

    /**
     * Getter for `headerDesktop` property, used to render `<h1>` tag on desktops.
     *
     * If `headerDesktop` property was not setted by [[setHeaderDesktop]], [[getTitle()]] will be returned. If `headerDesktop`
     * property is false, `<h1>` tag will not be rendered.
     *
     * @return string|false
     */
    public function getHeaderDesktop()
    {
        if ($this->_headerDesktop === null) {
            return $this->getTitle();
        }

        return $this->_headerDesktop;
    }

    /**
     * Setter for `headerDesktop` property
     *
     * @param string|false $header
     */
    public function setHeaderDesktop($header): void
    {
        $this->_headerDesktop = $header;
    }

    /**
     * Getter for `headerMobile` property, used to render header in navbar on mobiles.
     *
     * If `headerMobile` property was not setted by [[setHeaderMobile]], [[getTitle()]] will be returned.
     *
     * @return string
     */
    public function getHeaderMobile()
    {
        if ($this->_headerMobile === null) {
            return $this->getTitle();
        }

        return $this->_headerMobile;
    }

    /**
     * Setter for `headerMobile` property
     *
     * @param string $headerMobile
     */
    public function setHeaderMobile($headerMobile): void
    {
        $this->_headerMobile = $headerMobile;
    }

    /**
     * Getter for `headerCrumb` property, used to render header last part of breadcrumbs
     *
     * If `headerCrumb` property was not setted by [[setHeaderCrumb]], [[getTitle()]] will be returned.
     *
     * @return string
     */
    public function getHeaderCrumb()
    {
        if ($this->_headerCrumb === null) {
            return $this->getTitle();
        }

        return $this->_headerCrumb;
    }

    /**
     * Getter for `headerCrumb` property
     *
     * @param string $headerCrumb
     */
    public function setHeaderCrumb($headerCrumb): void
    {
        $this->_headerCrumb = $headerCrumb;
    }
}