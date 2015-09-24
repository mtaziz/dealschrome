<div class="body_container">
    <div class="menu_bar"></div>
    <div class="gmap_header_div">
        <div class="container_24">
            <div class="grid_6 logo_div"> <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/DealsChrome v2 logo.png"> </div>
            <div class="grid_14 search_bar_div">
                <?php $this->renderPartial('fragments/queryform'); ?>
            </div>
            <div class="grid_4 account_div"> </div>
            <div class="clear"></div>
        </div>
        <!-- end of container_24 --> 
    </div>

    <div id="gmap_view_wrapper" style="position: relative;">
        <div id="changecenter_dialogue" style="z-index: 99; position:absolute; left:270px; top:50px; display:block;"></div>
        <div id="map_canvas" style="width:100%; height:800px"></div>

        <?php $this->renderPartial('fragments/gmap_sidemenu'); ?>
        <?php $this->renderPartial('fragments/gmap_dealcontent'); ?>
        <!-- end of gmap_side_menu --> 
    </div>
</div>

<!-- end of body_container -->


<div style="display: none;">
    <?php $this->renderPartial('fragments/gmap_dialog_changelocation'); ?>
</div>
