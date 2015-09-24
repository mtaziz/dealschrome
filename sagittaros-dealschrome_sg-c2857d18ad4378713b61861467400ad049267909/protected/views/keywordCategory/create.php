<?php
$this->breadcrumbs=array(
	'Keyword Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List KeywordCategory', 'url'=>array('index')),
	array('label'=>'Manage KeywordCategory', 'url'=>array('admin')),
);
?>

<h1>Create KeywordCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>