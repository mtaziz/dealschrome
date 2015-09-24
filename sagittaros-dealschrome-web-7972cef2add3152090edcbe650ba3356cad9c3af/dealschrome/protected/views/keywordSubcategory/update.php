<?php
$this->breadcrumbs=array(
	'Keyword Subcategories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List KeywordSubcategory', 'url'=>array('index')),
	array('label'=>'Create KeywordSubcategory', 'url'=>array('create')),
	array('label'=>'View KeywordSubcategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage KeywordSubcategory', 'url'=>array('admin')),
);
?>

<h1>Update KeywordSubcategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>