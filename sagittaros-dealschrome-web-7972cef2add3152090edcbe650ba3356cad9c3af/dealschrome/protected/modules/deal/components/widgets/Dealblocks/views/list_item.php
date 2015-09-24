<?php
if ($has_highlighting) {
    $title = property_exists($highlighting, 'title') ? $highlighting->title[0] : $doc->title;
    $desc = property_exists($highlighting, 'description') ? $highlighting->description[0] : $doc->description;
} else {
    $title = $doc->title;
    $desc = $doc->description;
}

$total_word_len = 350;
$titlelen = strlen($title);
$desc_len = max(50, $total_word_len - $titlelen);
$description = substr($desc, 0, $desc_len) . '...';

// correction for bigdeal.sg
if ($doc->dealsource == 'plus.bigdeal.sg' && strpos($description, ' ') == 1) {
    $temp = substr($description, 0, 1) . strtolower(substr($description, 3, 1)) . substr($description, 4);
    $description = $temp;
}
?>

<div class="deal_list_content">
    <div class="deal_list_details"> 

        <!-- thumb image start -->
        <div class="deal_list_image"> 
            <a class="deals89_image_container" href="<?php echo $doc->url; ?>" target="_blank"> 
                <img class="deals89_image" src="<?php echo $doc->imgsrc; ?>"> 
            </a> 
        </div>
        <!-- thumb image end -->

        <div class="deal_list_middle">
            <div class="deal_list_title"> 
                <a href="<?php echo $doc->url; ?>" target="_blank" title="<?php echo $title; ?>"><?php echo $doc->title; ?></a> 
            </div>
            <div class="deal_list_description"> <?php echo $description; ?> </div>
            <div class="deal_price">S$<?php echo $doc->price; ?>&nbsp;<span class="original_price"><?php echo $doc->worth; ?></span></div>
            <?php if ($doc->bought): ?>
                <div class="deal_sold"><?php echo $doc->bought; ?> sold</div>
            <?php endif; ?>

            <div class="deal_time_left"><b>Time left:</b> <span><?php echo $doc->timeleft; ?></span></div>


        </div>
        <div class="deal_list_right">
            <div class="deal_middle_left fl">




                <div class="deal_discount">                                       
                    <b>Discount: </b><?php echo $doc->discount; ?>%
                </div>

                <div class="deal_savings">
                    <b>Savings:</b> S$<?php echo $doc->savings; ?> 
                </div>
                <div class="deals_source"><a target="blank" href="http://<?php echo $doc->dealsource; ?>"><?php echo $doc->dealsource; ?></a></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <!-- deal_list_details --> 
    <?php $this->widget('admin.components.widgets.DealCategoryChanger', array('dealUrl' => $doc->url)); ?>
</div>





<div class="deal_list_content template">
    <div class="deal_list_details"> 

        <!-- thumb image start -->
        <div class="deal_list_image"> 
            <a class="deals89_image_container inject_url" href="#" target="_blank"> 
                <img class="deals89_image inject_imgsrc" src="#"> 
            </a> 
        </div>
        <!-- thumb image end -->

        <div class="deal_list_middle">
            <div class="deal_list_title"> 
                <a class="inject_url inject_title_attr inject_title" href="#" target="_blank" title="#">-</a> 
            </div>
            <div class="deal_list_description inject_description"> - </div>
            <div class="deal_price">
                <span class="inject_price"> - </span>
                &nbsp;
                <span class="original_price inject_worth"> - </span>
            </div>
            <div class="deal_sold inject_bought"> - </div>
            <div class="deal_time_left"><b>Time left:</b> <span class="inject_timeleft"> - </span></div>
        </div>

        <div class="deal_list_right">
            <div class="deal_middle_left fl">
                <div class="deal_discount">                                       
                    <b>Discount: </b><span class="inject_discount"> - </span>
                </div>
                <div class="deal_savings">
                    <b>Savings:</b><span class="inject_savings"> - </span> 
                </div>
                <div class="deals_source">
                    <a class="inject_dealsource" target="blank" href="#"> - </a>
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </div>
    <!-- deal_list_details --> 
</div>

