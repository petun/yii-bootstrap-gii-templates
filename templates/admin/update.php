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
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('app', '$label')=>array('index'),
	Yii::t('app', 'Update'),
);\n";
?>

$this->menu=array(
	array('label'=><?php echo "Yii::t('app', 'List ".$this->modelClass."')"; ?>, 'url'=>array('index')),
	array('label'=><?php echo "Yii::t('app', 'Create ".$this->modelClass."')";?>, 'url'=>array('create')),
);
?>

    <h1><?php echo "<?php Yii::t('app', 'Update ".$this->modelClass."');?>"; ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>