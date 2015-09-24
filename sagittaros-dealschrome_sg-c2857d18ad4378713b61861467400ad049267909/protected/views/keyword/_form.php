<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'keyword-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'term'); ?>
		<?php echo $form->textField($model,'term',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'term'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subcategory'); ?>
		<?php echo $form->textField($model,'subcategory',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'subcategory'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->textField($model,'category',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight'); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->