<?php
$this->breadcrumbs=array(
	'Keywords',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?
$categories = KeywordCategory::model()->findAll();
foreach($categories as $c) {
    echo "<div>";
    echo CHtml::link($c->name, array('keywords/category', 'category_id' => $c->id));
    echo "</div>";
}

?>