<div class="pages" id="searchpage">
    <div class="body_container">

        <div id="templates" style="display:none;">

            <div id="grid_item_template">
                <div class="deals89_request_details template">
                    <div class="deals89_details"> 
                        <a class="deals89_image_container inject_url" href="#" target="_blank"> 
                            <img class="deals89_image inject_imgsrc" src="#"> 
                        </a>
                        <div class="deals89_content">
                            <div class="deals89_name">
                                <a class="inject_title inject_url" href="#" target="_blank"> - </a>
                            </div>
                            <div class="deals89_range">
                                <span class="inject_price"> - </span> 
                                <span class="original_price inject_worth"> - </span>
                                <div class="sold_number inject_bought"> - </div>
                            </div>
                            <div class="deals89_requested_number">Time Left: <span class="inject_timeleft"> - </span></div>
                            <div class="deals89_branch">
                                <a class="inject_dealsource" target="blank" href="#"> - </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="list_item_template">

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

            </div>
            <div id="pin_item_template">

            </div>

        </div>

        <div class="header_div">
            <div class="container_24">
                <div class="grid_6 logo_div"> 
                    <a class="goToHome" href="#"> 
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/DealsChrome v2 logo - beta w280.png" /> 
                    </a>
                </div>


                <div class="grid_11 search_bar_div">

                    <?php $this->widget("DealFilter", array("view" => "query_form")); ?>

                </div> 


                <div class="grid_7 account_div">
                    <!-- originally for login and signup -->
                    <div class="search_top_right_bar">  
                        <div class="HeaderContainer search_header_container">
                            <ul id="Navigation">

                                <li> <a href="" class="nav">About<span></span></a>
                                    <ul>
                                        <li><a href="<?php echo $this->createUrl('/pages/default/aboutus'); ?>">About Us</a></li>
                                        <li class="beforeDivider"><a href="<?php echo $this->createUrl('/pages/default/faq'); ?>">FAQ</a></li>
                                        <li class="divider"><a href="<?php echo $this->createUrl('/pages/default/terms'); ?>">Terms</a></li>
                                        <li><a href="<?php echo $this->createUrl('/pages/default/privacy'); ?>">Privacy</a></li>
                                        <li><a href="<?php echo $this->createUrl('/pages/default/contactus'); ?>">Contact Us</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div> <!-- end of HeaderContainer -->

                        <div class="facebook-like-button">        
                            <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Fdealschrome&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21&amp;appId=326075870776996" 
                                    scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
                        </div>
                        <div class="twitter-follow-button">

                            <a href="https://twitter.com/dealschrome" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @dealschrome</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                        </div>
                    </div> <!-- end of search_top_right_bar -->



                </div>
                <div class="clear"></div>
            </div>
            <!-- end of container_24 --> 

        </div>
        <!-- end of header_div -->



        <div id="all_content_wrapper">
            <div class="search_details">
                <div class="container_24">
                    <div class="grid_4 details_title"> Search </div>
                    <div class="grid_9 details_results"> 
                        <?php $this->renderPartial('fragments/found_indicator', array('numFound' => 0)); ?> 
                    </div>
                    <div class="grid_10 details_others"> 
                        <div class="sort_by" style="float:left; margin-right: 10px; margin-top: 10px;">
                            Sort by:
                        </div>
                        <div class="sort_menu" style="height:20px; float:left; margin-right: 10px; margin-top: 5px;">

                            <?php $this->widget("DealFilter", array("view" => "dropdown")); ?>

                            &nbsp; 
                        </div>
                        <div class="view_nav_bar" style="float:left; margin-top: 10px;">

                            <?php $this->widget("DealFilter", array("view" => "layout_picker")); ?>

                        </div>

                    </div>
                    <div class="clear"></div>
                </div>
                <!-- end of container_24 --> 
            </div>
            <!-- end of search_details -->

            <div class="search_content_wrapper">
                <div class="container_24">
                    <div class="search_body">
                        <div class="grid_4 body_left">

                            <?php $this->widget("DealFilter", array("view" => "sidebar")); ?>

                            <p id="back-top" style="display: block; ">
                                <a href="#top"><span></span>Back to Top</a>
                            </p>

                        </div>
                        <!-- end of body_left -->
                        <div class="grid_20 body_right">

                            <div id="dealblocks_container">

                            </div>

                            <?php $this->renderPartial('fragments/loading_deal'); ?>

                            <div class="clear"></div>

                            <div class="footer">

                                <div class="footer_menu_wrapper">
                                    <div class="footer_menu">
                                        <ul>
                                            <li><a href="<?php echo $this->createUrl('/pages/default/aboutus'); ?>" title="About Us">About Us</a></li>
                                            <li><a href="<?php echo $this->createUrl('/pages/default/faq'); ?>">FAQ</a></li>
                                            <li><a href="<?php echo $this->createUrl('/pages/default/privacy'); ?>">Privacy Policy</a></li>
                                            <li><a href="<?php echo $this->createUrl('/pages/default/terms'); ?>">Terms and Conditions</a> </li>
                                            <li><a href="/contact">Contact us</a></li>

                                        </ul>
                                    </div>
                                    <div class="footer_menu_bottom">
                                        DealsChrome © 2012 Storepair Pte. Ltd. All Rights Reserved.
                                    </div>

                                </div>

                                <div class="social_links" "=""> 
                                     <div id="follow_us">Follow us on:</div>


                                    <div class="social_icons">
                                        <a href="http://www.facebook.com/dealschrome" target="_blank">
                                            <img src="/themes/chrome/images/socialmedia-icons/facebook" id="logo"></a> 
                                        <a href="http://www.twitter.com/dealschrome" target="_blank">
                                            <img src="/themes/chrome/images/socialmedia-icons/twitter" id="logo"></a> 
                                        <a href="https://plus.google.com/111133570718388353473" target="_blank"> 
                                            <img src="/themes/chrome/images/socialmedia-icons/googleplus" id="logo"> </a> 
                                        <a href="https://foursquare.com/dealschrome" target="_blank"> 
                                            <img src="/themes/chrome/images/socialmedia-icons/foursquare" id="logo"> </a>
                                        <a href="http://pinterest.com/dealschrome/" target="_blank">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/socialmedia-icons/big-p-button.png" width="32" height="32" alt="Follow Me on Pinterest" id="logo" />
                                        </a>



                                    </div>
                                </div> <!-- end of social_links -->
                                <div class="clear"></div>
                            </div>

                            <div class="clear"></div>
                        </div>
                        <!-- end of body_right --> 
                        <div class="clear"></div>
                    </div>

                    <!-- end of search_body --> 

                    <div class="clear"></div>
                </div>
                <!-- end of container_24 --> 
            </div> <!-- end of search_content_wrapper -->

            <div class="clear"></div>

        </div> <!-- end of all_content_wrapper -->

    </div>
</div>