<div class="pages">

    <div class="body_container">
        <div class="header_div">
            <div class="container_24">
                <div class="grid_6 logo_div"> 
                    <a href="<?php echo $this->createAbsoluteUrl('/deal/search'); ?>"> 
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/DealsChrome_logo_1.png" /> 
                    </a>
                </div>


                <div class="grid_11 search_bar_div">

                    <?php $this->renderPartial('deal.views.search.fragments.search_form'); ?>

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

        <div class="about_container">
            <div class="about_wrapper">
                <ul>
                    <li><a href="<?php echo $this->createUrl('/pages/default/aboutus'); ?>">About Us</a></li>
                    <li><a href="<?php echo $this->createUrl('/pages/default/contactus'); ?>">Contact Us</a></li>
                    <li><a class="green" href="<?php echo $this->createUrl('/pages/default/faq'); ?>">FAQ</a></li>
                    <li><a href="<?php echo $this->createUrl('/pages/default/terms'); ?>">Terms</a></li>
                    <li><a href="<?php echo $this->createUrl('/pages/default/privacy'); ?>">Privacy Policy</a></li>

                </ul>
            </div>

            <!-- end of about_wrapper -->

            <div class="about_content">
                <h2>Frequently Asked Questions</h2>
                <br>
                <h4>What is DealsChrome?</h4>
                DealsChrome is a daily deal discovery portal which lets you to discover the best deals in your city easily.<br>
                <br>
                <h4>What cities does DealsChrome operate in? </h4>
                Currently we are operating in Singapore and soon after we will be expanding to other cities. <br>
                <br>
                <h4>Where is the deal I purchase?</h4>
                DealsChrome does not sell deals directly. We direct you to the deal sites where you buy the deals. <br>
                <br>
                <h4>Can I subscribe to DealsChrome?</h4>
                Yes, absolutely! Kindly enter your email address at the landing page when you first visit the site. We will update you about our new features through email. <br>
                <br>
                <h4>Is my personal information secure on DealsChrome?</h4>
                Yes, absolutely! Kindly enter your email address at the landing page when you first visit the site. We will update you about our new features through email. <br>
                <br>
                <h4>Where is the mobile site or app?</h4>
                Coming soon! <br>
                <br>
                <h4>How do I get my deal sites listed?</h4>
                To list your deal sites with us, please first submit your daily deal site. Our team must approve your site before we can list it on DealsChrome. You'll receive an email with our decision within 3 business days. <br>
                <br>
                Want to learn more? Kindly email us at <a href="mailto:support@dealschrome.com"> support@dealschrome.com</a>. </div>

            <!-- end of about_content -->

            <div class="clear"></div>
        </div>

        <!-- end of about_container --> 
        <?php $this->renderPartial('fragments/footer'); ?>
    </div>
    <!-- end of body_container -->
</div>