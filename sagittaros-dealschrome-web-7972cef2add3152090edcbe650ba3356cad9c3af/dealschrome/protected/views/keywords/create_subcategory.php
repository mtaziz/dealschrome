<?php
$model = new KeywordSubcategory;
if(isset($_POST['KeywordSubcategory'])){
    $model->attributes = $_POST['KeywordSubcategory'];
    $model->save();
    $this->refresh();
}
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm');
    ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo "Create new subcategory : "; ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <?php echo $form->hiddenField($model, 'category', array('value' => $category_id)); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Create'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->