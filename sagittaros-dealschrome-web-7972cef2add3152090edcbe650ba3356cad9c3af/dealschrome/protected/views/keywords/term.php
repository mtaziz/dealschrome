<?php
$ajaxupdateSuccess = <<<"EOD"
function(data){
    eval('data = '+data);
    jQuery('#subcategory-'+data.subcategory).append(jQuery('#keyword-'+data.termId)[0].outerHTML);
    jQuery('#keyword-'+data.termId).remove();
}
EOD;

$ajaxUpdateCode = <<<"EOD"
var selectedSubcategory = $('#keyword-{$term->id} option:selected').val();
jQuery.ajax(
    {
        'url':'/index.php?r=keywords/ajaxUpdate',
        'data': {
            'termId': {$term->id},
            'subCategory': selectedSubcategory,
            'passcode': 'a12(87878eu8u8j)iaOp*9sjc',
        },
        'cache': false,
        'success': {$ajaxupdateSuccess},
    }
);
EOD;

$ajaxDeleteSuccess = <<<"EOD"
    function(){
        jQuery('#keyword-{$term->id}').remove();
    }    
EOD;
?>

<div id="keyword-<?php echo $term->id; ?>" style="margin: 3px; float:left; display: block; border: 1px solid black; padding: 3px;">
    <div><?php echo $term->term; ?></div>


    <?php
    echo CHtml::beginForm();
    echo CHtml::dropDownList('subcategory', $subcategory->id, $subcategories, array(
        'onchange' => $ajaxUpdateCode,
    ));
    //echo CHtml::hiddenField('term_id',$term->id);
    echo CHtml::endForm();
    ?>


    <?php
    echo CHtml::beginForm(array('keywords/ajaxDelete'));
    echo CHtml::hiddenField('id', $term->id);
    echo CHtml::hiddenField('passcode','u98u8acja8scja89sjcjGBHJ');
    echo CHtml::ajaxSubmitButton("delete", array('keywords/ajaxDelete'), array(
        'success' => $ajaxDeleteSuccess,
    ));
    echo CHtml::endForm();
    ?>
</div>