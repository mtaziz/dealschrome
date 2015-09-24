<?php
$this->breadcrumbs=array(
	'Keyword Subcategories',
);

$this->menu=array(
	array('label'=>'Create KeywordSubcategory', 'url'=>array('create')),
	array('label'=>'Manage KeywordSubcategory', 'url'=>array('admin')),
);
?>

<h1>Keyword Subcategories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
