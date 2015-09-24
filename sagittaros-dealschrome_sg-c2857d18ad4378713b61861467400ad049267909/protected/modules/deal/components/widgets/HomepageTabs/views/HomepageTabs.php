<div class="homepage_navi">
    
    <div class="navi_click">
        Click below to explore more
    </div>
    
    <ul class="navi-organic">
        <li class="nav-one"><a href="#gmap"><img class="tab_icon_nearby" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tab_icons/DealsChrome Icon v2.png">Deals nearby</a></li>
        <li class="nav-two"><a href="#top-five-deals"><img class="tab_icon" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tab_icons/star.png">Best Sellers</a></li>
        <li class="nav-three"><a href="#top-food-deals"><img class="tab_icon" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tab_icons/food.png">Top Eateries</a></li>
        <li class="nav-four"><a href="#top-travel-deals"><img class="tab_icon" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tab_icons/travel.png">Journeys</a></li>
        <li class="nav-five"><a href="#top-beauty-deals"><img class="tab_icon" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tab_icons/beauty.png">Beauty</a></li>
        <li class="nav-sixth last"><a href="#top-fun-deals"><img class="tab_icon" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tab_icons/fun.png">Fun & Activities</a></li>
    </ul>
    <div class="list-wrap homepage-top-deals-wrapper">

        <ul id="gmap" class="hide"> 
            <?php $this->widget("DealsMap"); ?>
            <div class="clear"></div>
            <div id="gmap_tips">Tip: Zoom out to see more deals around your area.</div> 
        </ul>

        <ul id="top-five-deals" class="hide">
            <?php echo $mostWanted; ?>
        </ul>

        <ul id="top-food-deals" class="hide">
            <?php echo $mostWantedFood; ?>
        </ul>

        <ul id="top-travel-deals" class="hide">
            <?php echo $mostWantedTravel; ?>
        </ul>

        <ul id="top-beauty-deals" class="hide">
            <?php echo $mostWantedBeauty; ?>
        </ul>
        <ul id="top-fun-deals" class="hide">
            <?php echo $mostWantedFun; ?>
        </ul>
        
        
        
    </div>
    <!-- END List Wrap --> 

</div>
<!-- END Organic Tabs (Example One) --> 