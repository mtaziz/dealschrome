
<div class="deal_list_content">
    <div class="deal_list_details"> 
        <!-- thumb image start -->
        <div class="deal_list_image"> 
            <a class="deals89_image_container" href="<?php echo $doc->url; ?>" target="_blank"> 
                <img class="deals89_image" src="<?php echo Yii::app()->controller->createUrl('/imagecache',array("width"=>210,"url"=>$doc->imgsrc)); ?>"> 
            </a> 
        </div>
        <!-- thumb image end -->
        <div class="deal_list_middle">
            <div class="deal_list_title"> 
                <a href="<?php echo $doc->url; ?>" target="_blank"><?php echo $doc->title; ?></a> 
            </div>
            <div class="deal_list_description"> <?php echo $description; ?></div>
            <div class="deal_price">S$<?php echo $doc->price; ?>&nbsp;<span class="original_price">S$<?php echo $doc->worth; ?></span></div>
            <div class="deal_sold"><?php echo $doc->bought; ?> sold</div>
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
</div>