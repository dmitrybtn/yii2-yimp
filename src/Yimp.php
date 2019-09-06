<?php

namespace dmitrybtn\yimp;

use Yii;
use yii\base\BaseObject;
use yii\base\ErrorException;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;


/**
 * Main package class, used to render layout snippets.
 *
 * To use it in your layout you must firstly register it:
 *
 * ```
 * $yimp = new Yimp();
 * $yimp->register($this);
 * ```
 *
 * TODO: Github link
 *
 * On initialisation, [[Yimp::nav]] and [[Yimp::menu]] properties are instantiated.
 *
 * To instantiate [[Yimp::nav]] property, firstly existence of `Yii::$app->controller->nav` is checked. If `Yii::$app->controller->nav` property
 * exists and is instance of [[Navigator]], it is imported in [[Yimp::nav]] property. Otherwise it is created via
 * DI container by alias, stored in [[Yimp::DEFAULT_NAV_ALIAS]]. If you want to set default navigator (i.e. to keep
 * your left menu while working with third-party modules), you can do the following:
 *
 * ```
 * Yii::$container->set(Yimp::DEFAULT_NAV_ALIAS, [
 *     'class' => '\your\navigator\Class',
 *     // Your config
 * ])
 * ```
 *
 * [[Yimp::menu]] property is instantiated via DI container by alias, stored in [[Yimp::DEFAULT_MENU_ALIAS]]. You can
 * override it in same way, as you can do it for [[Yimp::nav]] property.
 *
 *
 * @method beginSidebars()
 * @method beginLeftSidebar()
 * @method endLeftSidebar()
 * @method beginRightSidebar()
 * @method endRightSidebar()
 * @method endSidebars()
 * @method beginContent()
 * @method endContent()
 *
 * @author Dmitry Tishurin <dmitrybtn@ya.ru>
 */
class Yimp extends BaseObject
{
    /**
     * Left sidebar marker, used to define blocks in layout
     */
    const SIDEBAR_LEFT = 'blockLeftSidebar';


    /**
     * Right sidebar marker, used to define blocks in layout
     */
    const SIDEBAR_RIGHT = 'blockRightSidebar';

    /**
     * Footer marker, used to define blocks in layout
     */
    const FOOTER = 'blockFooter';

    /**
     * Used by [[MenuAdapter]] in [[MenuAdapter::mode]] property and `visibleMode` menu item config to config `visible`
     * property separately for desktops and mobiles.
     */
    const DESKTOP = 'desktop';

    /**
     * Used by [[MenuAdapter]] in [[MenuAdapter::mode]] property and `visibleMode` menu item config to config `visible`
     * property separately for desktops and mobiles.
     */
    const MOBILE = 'mobile';


    /**
     * DI alias, used to instantiate [[Yimp::nav]] property
     */
    const DEFAULT_NAV_ALIAS = 'yimp-nav';

    /**
     * DI config, used to instantiate [[Yimp::nav]] property
     */
    const DEFAULT_NAV_CONFIG = [
        'class' => 'dmitrybtn\yimp\Navigator',
    ];

    /**
     * DI alias, used to instantiate [[Yimp::menu]] property
     */
    const DEFAULT_MENU_ALIAS = 'yimp-menu';

    /**
     * DI config, used to instantiate [[Yimp::menu]] property
     */
    const DEFAULT_MENU_CONFIG = [
        'class' => 'dmitrybtn\yimp\MenuAdapter',
    ];

    /**
     * @var Navigator Component, used to get layout config from controller
     */
    public $nav = self::DEFAULT_NAV_ALIAS;

    /**
     * @var MenuAdapter Component, used to render menu widgets
     *
     */
    public $menu = self::DEFAULT_MENU_ALIAS;

    /**
     * @var View View object, used to render layout widgets.
     */
    public $view;


    /**
     * @var array HTML templates for layout snippets.
     *
     * Each item can be used by calling method with same name, i.e. `$yimp->beginSidebars()`.
     */
    public $templates = [
        'beginSidebars' => [
            '<div class="container-fluid position-fixed">',
            '    <div class="row justify-content-center">',
        ],
        'beginLeftSidebar' => [
            '        <div class="d-none d-xl-block col-xl-2">',
        ],
        'endLeftSidebar' => [
            '        </div>',
        ],
        'beginRightSidebar' => [
            '        <div class="d-none d-xl-block col-xl-2 offset-xl-8">',
        ],
        'endRightSidebar' => [
            '        </div>',
        ],
        'endSidebars' => [
            '    </div>',
            '</div>'
        ],
        'beginContent' => [
            '<div class="container-fluid">',
            '    <div class="row justify-content-center">',
            '        <div class="col-12 col-md-11 col-lg-10 col-xl-8">',
        ],
        'endContent' => [
            '        </div>',
            '    </div>',
            '</div>',
        ]
    ];


    /**
     * Class initialisation
     *
     * @throws ErrorException
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        // Instantiate navigator
        if (Yii::$app->controller->canGetProperty('nav') && Yii::$app->controller->nav instanceof Navigator) {
            $this->nav = Yii::$app->controller->nav;
        } else {

            if ($this->nav == self::DEFAULT_NAV_ALIAS && !Yii::$container->has($this->nav)) {
                Yii::$container->set($this->nav, static::DEFAULT_NAV_CONFIG);
            }

            $this->nav = Yii::createObject($this->nav);
        }

        // Instantiate menu
        if ($this->menu == self::DEFAULT_MENU_ALIAS && !Yii::$container->has($this->menu)) {
            Yii::$container->set($this->menu, static::DEFAULT_MENU_CONFIG);
        }

        $this->menu = Yii::createObject($this->menu);

        if (!($this->menu instanceof MenuAdapter)) {
            throw new ErrorException('Menu must be instance of MenuAdapter class');
        }
    }

    /**
     * Registers asset bundles for YIMP
     *
     * @param View $view
     */
    public function register(View $view)
    {
        $this->view = $view;

        Asset::register($view);
    }

    // Layout rendering methods

    /**
     * Renders navbar
     *
     * @return string Navbar HTML
     */
    public function navbar()
    {
        return $this->view->render('@dmitrybtn/yimp/views/layout-navbar', ['yimp' => $this]);
    }


    /**
     * Renders left menu
     *
     * @param array $config
     * @return string Left menu HTML
     * @throws \Exception
     */
    public function menuLeft($config = [])
    {
        $config['items'] = $this->nav->menuLeft;

        return $this->menu->widget($config);
    }

    /**
     * Renders right menu
     *
     * @param array $config
     * @return string Right menu HTML
     * @throws \Exception
     */
    public function menuRight($config = [])
    {
        $config['items'] = $this->nav->menuRight;

        return $this->menu->widget($config);
    }

    /**
     * Renders top menu
     *
     * @param array $config
     * @return string Top menu HTML
     * @throws \Exception
     */
    public function menuTop($config = [])
    {
        $config['items'] = $this->nav->menuTop;

        return $this->menu->widget($config);
    }

    /**
     * Renders `<h1>` tag for desktops
     *
     * @return string
     */
    public function headerDesktop()
    {
        $ret = [];

        if ($this->nav->headerDesktop !== false) {
            $ret = [
                '<h1 class="d-none d-md-block">',
                Html::encode($this->nav->headerDesktop),
                '</h1>'
            ];
        }

        return implode("\n", $ret);
    }

    /**
     * Renders page header, displayed in navbar on mobiles
     *
     * @param array $options
     * @return string
     */
    public function headerMobile($options = [])
    {
        $label = Html::encode($this->nav->headerMobile);

        if ($this->nav->crumbs !== false) {
            $url = $this->nav->crumbs[count($this->nav->crumbs) - 1]['url'] ?? Url::home();

            return Html::a('<div class="back"><</div>' . $label, $url, $options);
        } else {
            return Html::tag('span', $label, $options);
        }
    }

    /**
     * Overrides parent method to use items from [[Yimp::templates]] as functions.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed|string
     */
    public function __call($name, $arguments)
    {
        if (isset($this->templates[$name])) {
            return implode("\n", $this->templates[$name]);
        } else {
            return parent::__call($name, $arguments);
        }
    }

}