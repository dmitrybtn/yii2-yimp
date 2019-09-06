## YIMP - Панель управления для Yii 2 на Bootstrap 4

### Концепция

YIMP - это панель управления, предназначенная для создания собственных CMS или информационных систем.

YIMP предоставляет лейаут, адаптированный для мобильных устройств и включающий в себя заголовок страницы, хлебные крошки,
а также три меню - верхнее, левое и правое. Эти свойства настраиваются в контроллере и передаются в лейаут через
специальный класс Navigator.

### Установка через Composer

В настоящее время разработка еще не завершена. Релиз версии 0.1 запланирован на 10 сентября 2019 года. Версия 1.0 должна
выйти до конца сентября 2019 года. Если Вы хотите попробовать YIMP, установите через Composer версию dev-master. Для этого: 

запустите команду

```
php composer.phar require dmitrybtn/yii2-yimp:dev-master
```

или добавьте

```
"dmitrybtn/yii2-yimp": "dev-master"
```

в секцию **require** вашего `composer.json`.

### Быстрый старт

#### Подключение лейаута

Лейаут хранится в папке `vendor/dmitrybtn/yii2-yimp/views/layout`. Для подключения лейаута 
**рекомендуется скопировать его код в приложение**. Тем не менее, в простейших приложениях можно подключить лейаут из пакета, для 
этого в настройках приложения нужно указать: 

```
'layout' => '@dmitrybtn/yimp/views/layout',
```

#### Подключение навигатора

В приложении необходимо определить класс, унаследованный от \dmitrybtn\yimp\Navigator. Этот класс будет использоваться 
для передачи заголовков, меню и хлебных крошек из контроллера в лейаут. При определении класса рекомендуется настроить
левое меню, ведущее в основные ветки приложения. Например, так: 

```
namespace app\components;

class Navigator extends \dmitrybtn\yimp\Navigator
{
    public function init()
    {
        parent::init();

        $this->menuLeft = [
            ['label' => 'Main menu'],
            ['label' => 'About', 'url' => ['/site/about']],
        ];
    }
}
```

В контроллере нужно определить свойство nav, являющееся объектом класса Navigator. В действиях контроллера нужно настроить
поля свойства nav, соответствующие заголовкам, меню и хлебным крошкам. Например, так:

```
class SiteController extends \yii\web\Controller
{
    public $nav;

    public function init()
    {
        parent::init();

        $this->nav = new Navigator();
    }

    public function actionAbout()
    {
        $this->nav->title = 'About';

        return $this->render('about');
    }

    ...
}
```

#### Подключение Gii

В состав YIMP входят шаблоны для CRUD и контроллеров. Для их подключения в настройках приложения нужно указать:

```
    'modules' => [
        ...
        'gii' => [
             'class' => 'yii\gii\Module',
             'allowedIPs' => ['127.0.0.1', '::1'],
             'generators' => [
                 'crud' => [
                     'class' => 'yii\gii\generators\crud\Generator',
                     'templates' => [
                         'yimp' => '@dmitrybtn/yimp/gii/crud'
                     ]
                 ],
                 'controller' => [
                     'class' => 'yii\gii\generators\controller\Generator',
                     'templates' => [
                         'yimp' => '@dmitrybtn/yimp/gii/controller'
                     ]
                 ]
             ],
        ...
    ]
```

#### Подключение ErrorAction

В состав YIMP входит ErrorAction, который можно подключить согласно документации на Yii.

### Рекомендации

Для подключения навигатора рекомендуется создать в приложении базовый класс для всех контроллеров
и определить в нем свойство `nav`. Все остальные контроллеры рекомендуется наследовать от базового.

Левое меню рекомендуется использовать как главное меню приложения. Верхнее меню - для опций текущего пользователя (логин, 
логаут, настройки профиля). Правое меню - для опций текущего действия (например, для действия View там будут пункты Update 
и Delete). Левое и верхнее меню рекомендуется настроить в вашей реализации класса Navigator, а правое меню - в коде действий.

Заголовки действий и хлебные крошки рекомендуется определять через статические методы контроллеров. Например, так:

```
class OrderController extends \yii\web\Controller
{
    public $nav;

    public function init()
    {
        parent::init();

        $this->nav = new Navigator();
    }

    public static function titleIndex()
    {
        return 'Заказы';
    }

    public static function titleView($order)
    {
        return 'Заказ № ' . $order->id;
    }

    public static function crumbsToIndex()
    {
        return [
            ['label' => static::titleIndex(), 'url' => ['index']]
        ];
    }

    public function actionIndex()
    {
        ...
        
        $this->nav->title = static::titleIndex();

        ...
    }

    public function actionView()
    {
        ...
        
        $this->nav->title = static::titleView();        
        $this->nav->crumbs = static::crumbsToIndex();

        ...
    }

}
``` 

В этом примере класс OrderController отвечает за заказы. Действие order/index будет имеет заголовок "Заказы". Очевидно, 
что слово "Заказы" также должно быть пунктом главного меню приложения, а также частью хлебных крошек для других действий. 
Как видите, это слово можно получить из любого места приложения, вызвав метод `OrderController::titleIndex()`.

Аналогично с хлебными крошками. Например, если появляется класс ItemController, отвечающий за товары в заказе, то действие 
`item/create` может иметь хлебные крошки "Главная / Заказы / Заказ № 1 / Добавить товар". Для формирования таких хлебных 
крошек в классе ItemController достаточно будет вызвать `$this->nav->crumbs = OrderController::crumbsToView($item->order)`.

Подобный подход реализован в шаблонах Gii, входящих в состав YIMP.

### Дополнительно

#### Виджеты

Свободное место в футере и боковых панелях может быть использовано для виджетов. Если вам нужно вывести виджет только для одного
действия, вы можете в представлении для этого действия определить [блок](https://www.yiiframework.com/doc/guide/2.0/ru/structure-views#using-blocks):

```
<?php $this->beginBlock(Yimp::SIDEBAR_RIGHT); ?>
    <div class="sidebar-form-controls border rounded p-3">
        <div class="h5">Caption</div>
        Your widget HTML
    </div>
<?php $this->endBlock(); ?>
```

Для использования блоков в YIMP определены константы `Yimp::SIDEBAR_LEFT`, `Yimp::SIDEBAR_RIGHT`, `Yimp::FOOTER`.

Обратите внимание, что боковые панели с виджетами отображаются только на больших экранах (xl). Для меньших экранов
рекомендуется переопределить виджеты подобно тому, как это сделано в форме.

#### Иконки

Поскольку Bootstrap 4 не поддерживает иконки, в YIMP используются иконки от [FontAwesome](https://fontawesome.com/icons).
Они подключаются в момент регистрации ресурсов YIMP, поэтому вы можете использовать их в своем приложении согласно
документации к FontAwesome.

#### Меню

Для настройки левого, правого и верхнего меню используются свойства навигатора `menuLeft`, `menuRight` и `menuTop`.
В этих свойствах необходимо указать настройки для свойства [items компонента yiisoft/bootstrap4/Nav](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/api/2.0/yii-bootstrap4-nav#$items-detail), например так:

```
    public function actionIndex()
    {
        ... 

        $this->nav->menuRight = [
            ['label' => 'Options'],
            ['label' => static::titleCreate(), 'url' => ['create']],
        ];

        ...
    }

```

Помимо известных настроек, могут быть указаны также следующие настройки:

 - `active`: В оригинальном виджете он имеет тип bool. В YIMP можно также использовать строку, соответствующую маске маршрута.
   Например, если для главного меню указать `'active' => 'order/*'`, пункт будет активен для любого действия из OrderController.
   Подробности см. MenuAdapter, RouteHelper.
 - `visibleMode`: YIMP рендерит каждое меню дважды - для десктопов и для мобильных устройств. Если вы хотите вывести элемент 
    только для одного типа устройств, укажите здесь `Yimp::DESKTOP` или `YIMP::MOBILE`. Обратите внимание, что эта настройка
    никак не связана с CSS.


#### Стилизация

YIMP написан с расчетом на максимальное использование возможностей Bootstrap 4. Все, что можно было сделать классами
Bootstrap 4, сделано именно так. Тем не менее, для части элементов пришлось определять собственные стили, которые используют
переменные Bootstrap 4 в основном для определения цветов. Стили Yimp хранятся в файле vendor\dmitrybtn\yii2-yimp\assets\css\yimp.scss.

Если вы решите использовать собственную таблицу стилей, то нужно [отключить стили Bootstrap](https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/guide/2.0/ru/topics-sass) 
и стили Yimp, указав в настройках приложения: 

```
    'assetManager' => [
        'bundles' => [
            'yii\bootstrap4\BootstrapAsset' => [
                'css' => [],
            ],
            'dmitrybtn\yimp\Asset' => [
                'css' => [],
            ]
        ]
    ]
```