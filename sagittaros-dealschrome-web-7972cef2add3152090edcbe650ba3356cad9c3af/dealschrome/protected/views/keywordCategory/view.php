<?php
$this->breadcrumbs=array(
	'Keyword Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List KeywordCategory', 'url'=>array('index')),
	array('label'=>'Create KeywordCategory', 'url'=>array('create')),
	array('label'=>'Update KeywordCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete KeywordCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage KeywordCategory', 'url'=>array('admin')),
);
?>

<h1>View KeywordCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
