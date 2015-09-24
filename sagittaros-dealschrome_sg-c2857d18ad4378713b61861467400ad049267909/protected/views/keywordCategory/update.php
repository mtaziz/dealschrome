<?php
$this->breadcrumbs=array(
	'Keyword Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List KeywordCategory', 'url'=>array('index')),
	array('label'=>'Create KeywordCategory', 'url'=>array('create')),
	array('label'=>'View KeywordCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage KeywordCategory', 'url'=>array('admin')),
);
?>

<h1>Update KeywordCategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>