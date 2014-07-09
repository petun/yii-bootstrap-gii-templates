<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
<?php echo "?>\n"; ?>

<?php
echo "<?php\n";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('app', '$label')=>array('index'),
	Yii::t('app', 'Create'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('app', 'List <?php echo $this->modelClass; ?>'), 'url'=>array('index')),
);
?>

<h1><? echo "<?php echo Yii::t('app','Create ".$this->modelClass."'); ?>" ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>