<?php
$this->breadcrumbs=array(
	'Keyword Subcategories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List KeywordSubcategory', 'url'=>array('index')),
	array('label'=>'Manage KeywordSubcategory', 'url'=>array('admin')),
);
?>

<h1>Create KeywordSubcategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>