<div class="pages" id="homepage">
    <div id="main_container">

        <?php $this->widget('Mc_suite', array('view' => 'popper')); ?>

        <div id="overlay_background"> </div>


        <div id="top_nav_bar">
            <div class="top_container">
                <div class="top_country">
                    Singapore
                </div>

                <ul id="site_nav">
                    <li></li>
                    <!--<li><a href="<?php echo $this->createUrl('/pages/default/aboutus'); ?>"></a></li>-->
                </ul>

                <div class="top_combine_wrapper">
                    <div class="HeaderContainer homepage_header_container">

                    </div> 

                    <div class="facebook-like-button">       
                        <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Fdealschrome&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21&amp;appId=326075870776996"
                                scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
                    </div>
                    <div class="twitter-follow-button">

                        <a href="https://twitter.com/dealschrome" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @dealschrome</a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    </div>

                    <div class="subscribe_button"><a onClick='$("#popper-wrapper").fadeIn(100);$("#overlay_background").fadeIn(800);'>Subscribe</a></div> 
                </div>

                <div class="clear"></div>
            </div>
        </div>


        <?php $this->widget('Mc_suite', array('view' => 'infobar')); ?>

        <div class="clear"></div>
        <div class="body_container home_container">
            <div class="mid_container">
                <div class="body_logo">
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/DealsChrome logo 1 w400 - beta and tagline.png" /> 
                </div>
                <!-- end of body_logo -->

                <div class="body_search_bar">
                    <?php $this->renderPartial('fragments/search_form'); ?>
                </div>

                <!-- end of body_search_bar -->


                <div class="body_alldeals">
                    <div class="alldeals_click">
                        <a class="goToNewSearch" href="#"><?php echo "Click here to view all " . $found . " deals in Singapore"; ?></a>
                    </div>
                </div>

                <?php $this->widget('TopSearches'); ?>

                <?php $this->widget('HomepageTabs'); ?>

            </div>
            <!-- end of container_24 -->
        </div>
        <!-- end of body_container -->

        <div class="clear"></div>

        <?php $this->renderPartial('pages.views.default.fragments.footer'); ?>
    </div>
</div>

