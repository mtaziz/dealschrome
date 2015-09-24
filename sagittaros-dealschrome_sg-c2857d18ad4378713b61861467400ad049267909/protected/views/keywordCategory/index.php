<?php
$this->breadcrumbs=array(
	'Keyword Categories',
);

$this->menu=array(
	array('label'=>'Create KeywordCategory', 'url'=>array('create')),
	array('label'=>'Manage KeywordCategory', 'url'=>array('admin')),
);
?>

<h1>Keyword Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
