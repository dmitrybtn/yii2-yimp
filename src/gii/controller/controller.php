<?php
/**
 * This is the template for generating a controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

class <?= StringHelper::basename($generator->controllerClass) ?> extends <?= '\\' . trim($generator->baseClass, '\\') . "\n" ?>
{
    public $nav;

    public function init()
    {
        parent::init();

        // Create Navigator object, used in your app
        // $this->nav = new ...
    }

<?php foreach ($generator->getActionIDs() as $action): ?>

    /**
     * Title for <?= Inflector::id2camel($action) ?> action.
     */
    public static function title<?= Inflector::id2camel($action) ?>()
    {
        return '<?= Inflector::id2camel($action) ?>';
    }
<?php endforeach; ?>
<?php foreach ($generator->getActionIDs() as $action): ?>

    /**
     * <?= Inflector::id2camel($action) ?> action.
     */
    public function action<?= Inflector::id2camel($action) ?>()
    {
        $this->nav->title = static::title<?= Inflector::id2camel($action) ?>();

        return $this->render('<?= $action ?>');
    }
<?php endforeach; ?>
}
