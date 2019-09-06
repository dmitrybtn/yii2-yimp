<?php


namespace dmitrybtn\yimp;


use Yii;
use yii\base\BaseObject;

/**
 * Base class to pass headers, breadcrumbs and menu settings from controller to layout.
 *
 * To use YIMP, you should extend this class in your application, and include it in your controllers as `nav` property like this:
 *
 * ```
 * class SiteController extends \yii\web\Controller
 * {
 *     public $nav;
 *
 *     public function init()
 *     {
 *         parent::init();
 *         $this->nav = new Navigator();
 *     }
 *
 *     public function actionAbout()
 *     {
 *         $this->nav->title = 'About';
 *         return $this->render('about');
 *     }
 * }
 * ```
 *
 * When [[Yimp]] class inits, it looks for `nav` property of current controller, and if this property exists and is instance of
 * [[Navigator]], Yimp uses it to render the corresponding layout snippets. If current controller does not have `nav`
 * property, Yimp will use navigator, created via DI Container by alias, stored in [[Yimp::DEFAULT_NAV_ALIAS]]. That's why, if you
 * want to set default navigator (i.e. to keep your left menu while working with third-party modules), you can do the following:
 *
 * ```
 * Yii::$container->set(Yimp::DEFAULT_NAV_ALIAS, [
 *     'class' => '\your\navigator\Class',
 *     // Your config
 * ])
 * ```
 *
 * @property string $title Page title, rendered in <title> tag
 * @property string|false $header
 * @property string $headerCrumb
 * @property string $headerDesktop
 * @property string $headerMobile
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class Navigator extends BaseObject
{
    private $_title;
    private $_headerDesktop;
    private $_headerMobile;
    private $_headerCrumb;

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