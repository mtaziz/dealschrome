<div class="view">
<?php d($data->getRelated("subcategory0"));?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('term')); ?>:</b>
	<?php echo CHtml::encode($data->term); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subcategory')); ?>:</b>
	<?php echo CHtml::encode($data->subcategory); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category')); ?>:</b>
	<?php echo CHtml::encode($data->category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />


</div>