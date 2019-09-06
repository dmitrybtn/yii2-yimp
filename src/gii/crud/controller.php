<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    public $nav;

    public function init()
    {
        parent::init();

        // Create Navigator object, used in your app
        // $this->nav = new ...
    }

    /**
     * Title for Index action
     */
    public static function titleIndex()
    {
        return <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
    }

    /**
     * Title for View action
     */
    public static function titleView(<?= $modelClass ?> $model)
    {
        return $model-><?= $generator->getNameAttribute() ?>;
    }

    /**
     * Title for Create action
     */
    public static function titleCreate()
    {
        return <?= $generator->generateString('Create') ?>;
    }

    /**
     * Title for Update action
     */
    public static function titleUpdate()
    {
        return <?= $generator->generateString('Update') ?>;
    }

    /**
     * Title for Delete action
     */
    public static function titleDelete()
    {
        return <?= $generator->generateString('Delete') ?>;
    }

    /**
     * Breadcrumbs to Index action
     */
    public static function crumbsToIndex()
    {
        return [
            ['label' => static::titleIndex(), 'url' => ['index']]
        ];
    }

    /**
     * Breadcrumbs to View action
     */
    public static function crumbsToView(<?= $modelClass ?> $model)
    {
        return array_merge(static::crumbsToIndex(), [
            ['label' => static::titleView($model), 'url' => ['view', <?= $urlParams ?>]],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->nav->title = static::titleIndex();

        $this->nav->menuRight = [
            ['label' => <?= $generator->generateString('Options') ?>],
            ['label' => static::titleCreate(), 'url' => ['create', 'returnUrl' => Url::current()]],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        $this->nav->title = static::titleIndex();

        $this->nav->menuRight = [
            ['label' => <?= $generator->generateString('Options') ?>],
            ['label' => static::titleCreate(), 'url' => ['create', 'returnUrl' => Url::current()]],
        ];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        $this->nav->title = static::titleView($model);
        $this->nav->crumbs = static::crumbsToIndex();

        $this->nav->menuRight = [
            ['label' => <?= $generator->generateString('Options') ?>],
            ['label' => static::titleUpdate(), 'url' => ['update', <?= $urlParams ?>, 'returnUrl' => Url::current()]],
            ['label' => static::titleDelete(), 'url' => ['delete', <?= $urlParams ?>], 'linkOptions' => ['data' => ['confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>, 'method' => 'POST']]],
        ];

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($returnUrl, $successUrl = null)
    {
        $model = new <?= $modelClass ?>();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($successUrl ?: ['view', <?= $urlParams ?>]);
        }

        $this->nav->title = static::titleCreate();
        $this->nav->crumbs = static::crumbsToIndex();

        return $this->render('create', [
            'model' => $model,
            'cancelUrl' => $returnUrl,
        ]);
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(<?= $actionParams ?>, $returnUrl)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($returnUrl);
        }

        $this->nav->title = static::titleUpdate();
        $this->nav->crumbs = static::crumbsToView($model);


        return $this->render('update', [
            'model' => $model,
            'cancelUrl' => $returnUrl,
        ]);
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(<?= $actionParams ?>, $returnUrl = ['index'])
    {
        $this->findModel(<?= $actionParams ?>)->delete();

        return $this->redirect($returnUrl);
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(<?= $generator->generateString('The requested page does not exist.') ?>);
    }
}
