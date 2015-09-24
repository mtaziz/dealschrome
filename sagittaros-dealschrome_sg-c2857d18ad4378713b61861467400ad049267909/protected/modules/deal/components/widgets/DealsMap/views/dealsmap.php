<div style="position: relative;">

    <div id="changecenter_dialogue" style="z-index: 99; position:absolute; left:130px; top:50px; display:block;"></div>
    <div id="map_canvas" style="width:940px; height:500px"></div>


    <div id="gmap_deals_div" style="display:none;"> 

        <a id="close_button" title="" onclick="$('#gmap_deals_div').fadeOut(); return false" href="#" class="clode_button_wrapper">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/close_button.png" alt=""> 
        </a> 
        <a  target="_blank" class="mapdeal-url" href="">
            <img id="gmap_image_wrapper"  class="mapdeal-imgsrc" src="">
        </a>

        <div id="gmal_deal_content">
            
            <div id="gmap_title_wrapper"> 
                <a target="_blank" class="mapdeal-url" href="">
                    <div class="mapdeal-title"></div>
                </a>
            </div> 

            <div class="gmap_deals_range">
                <span class="gmap_after_price">
                    $10
                </span>

                <span class="gmap_original_price">
                    $30.00
                </span>

                <div class="gmap_sold_number">
                    207 sold
                </div>
            </div>   

            <div class="gmap_time_left">Time Left: <span class="gmap_time_left_span">13h 20m</span></div>
            <div class="gmap_branch"><a target="_blank" class="gmap_branch_link">outlet.com.sg</a></div>
        
        </div><!-- end gmap_deal_content -->
        
    </div>
    
</div>

<div style="display: none;">
    <div id="changecenter_dialogue_content" style="background: white; width: 300px; height:50px; padding: 10px;">
        Unable to find any deals near your location.
        Click <a onclick="focusToDealZone(); return false;" href="">here</a> to find more deals.
    </div>
</div>