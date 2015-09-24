<?php
if ($has_highlighting) {
    $title = property_exists($highlighting, 'title') ? $highlighting->title[0] : $doc->title;
} else {
    $title = $doc->title;
}

if (strlen($title) > 110) {
    $title = substr($title, 0, 110) . '...';
}
?>

<div class="box_pin masonry-brick">
    <div class="pin_image_wrapper">	
        <a class="deals-pin-wrapper" href="<?php echo $doc->url; ?>"><img src="<?php echo $doc->imgsrc; ?>"></a>
        <div class="pin_caption">
            <div class="pin_caption_content">
                
                <div class="pin_range"><?php echo $doc->price; ?> <span class="pin_original_price"><?php echo $doc->worth; ?></span>
                    <div class="pin_sold_number"><?php echo $doc->bought; ?> sold</div>
                </div>
                <div class="pin_time_left">Time Left: <?php echo $doc->timeleft; ?> </div>
                <div class="pin_branch"><a target="blank" href="http://plus.bigdeal.sg"><?php echo $doc->dealsource; ?></a></div>
            </div>
        </div> <!-- end of caption --> 
        <div class="clear"></div>
    </div> <!-- end of pin_image_wrapper -->



    <div class="pin-content">
        <div class="pin-title"><?php echo $title; ?><span></span></div>
    </div>

</div> <!-- end of box_pin -->