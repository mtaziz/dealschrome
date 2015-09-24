<?php
$this->breadcrumbs=array(
	'Keyword Subcategories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List KeywordSubcategory', 'url'=>array('index')),
	array('label'=>'Create KeywordSubcategory', 'url'=>array('create')),
	array('label'=>'Update KeywordSubcategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete KeywordSubcategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage KeywordSubcategory', 'url'=>array('admin')),
);
?>

<h1>View KeywordSubcategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'category',
	),
)); ?>
