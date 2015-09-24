<?php
$ajaxCreateSuccess = <<<"EOD"
function(data){
    jQuery('#textfield-subcategory-{$subcategory->id}').val('');
    if(data.charAt(0) == 1) {
        var content = data.substring(1);
        jQuery('#createTermError-{$subcategory->id}').html("");
        jQuery('#subcategory-{$subcategory->id}').append(content);
    } else {
        jQuery('#createTermError-{$subcategory->id}').html("<p>Keyword already exists</p>");
    }
}
EOD;
?>

<div class="subcategory_wrapper">

    <h2><?php echo $subcategory->name; ?></h2>

    <div id="subcategory-<?php echo $subcategory->id; ?>">
        <?php echo $termList; ?>
    </div>

    <div style="clear: both;"></div>

    <?php
    echo CHtml::beginForm('');
    echo CHtml::label("New keyword:  ", "term");
    echo CHtml::textField('term', '', array('id'=>'textfield-subcategory-'.$subcategory->id));
    echo CHtml::hiddenField('subcategory-id', $subcategory->id);
    echo CHtml::hiddenField('category-id', $category_id);
    echo CHtml::hiddenField('passcode', 'u98u8aUIUOa8scja89sjcjGBHJ');
    $ajaxoptions = array('success'=>$ajaxCreateSuccess);
    echo CHtml::ajaxSubmitButton("create", array('keywords/ajaxCreate'),$ajaxoptions);
    echo CHtml::endForm();
    ?>

    <div id="createTermError-<?php echo $subcategory->id; ?>"></div>
    <br>
</div>