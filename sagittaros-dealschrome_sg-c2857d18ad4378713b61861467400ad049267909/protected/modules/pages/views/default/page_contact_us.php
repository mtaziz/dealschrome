<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#contactform").validate();
    });
</script>

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
                    <li><a class="green" href="<?php echo $this->createUrl('/pages/default/contactus'); ?>">Contact Us</a></li>

                    <li><a href="<?php echo $this->createUrl('/pages/default/faq'); ?>">FAQ</a></li>
                    <li><a href="<?php echo $this->createUrl('/pages/default/terms'); ?>">Terms</a></li>
                    <li><a href="<?php echo $this->createUrl('/pages/default/privacy'); ?>">Privacy Policy</a></li>



                </ul>
            </div>

            <!-- end of about_wrapper -->

            <div class="about_content">
                <h2>Contact Us</h2>
                <br />
                Feel free to email us at <a href="mailto:support@dealschrome.com">support@dealschrome.com</a> with any question or media enquiries. <br />
                <br />
                Kindly follow us on facebook, Google+, Twitter, Foursquare and Pinterest for our latest updates.
                <div class="side_social_icons"> <a href="http://www.facebook.com/dealschrome" target="_blank"> <img src="http://dealschrome.com/themes/chrome/images/socialmedia-icons/facebook" alt="Follow Me on Facebook" id="logo"></a> <a href="http://www.twitter.com/dealschrome" target="_blank"> <img src="http://dealschrome.com/themes/chrome/images/socialmedia-icons/twitter" alt="Follow Me on Twitter" id="logo"></a> <a href="https://plus.google.com/111133570718388353473" target="_blank"> <img src="http://dealschrome.com/themes/chrome/images/socialmedia-icons/googleplus" alt="Follow Me on Google Plus" id="logo"> </a> <a href="https://foursquare.com/dealschrome" target="_blank"> <img src="http://dealschrome.com/themes/chrome/images/socialmedia-icons/foursquare" alt="Follow Me on foursquare" id="logo"> </a> <a href="http://pinterest.com/dealschrome/" target="_blank"> <img src="http://dealschrome.com/themes/chrome/images/socialmedia-icons/big-p-button.png" width="32" height="32" alt="Follow Me on Pinterest" id="logo"> </a> </div>
                <div class="border_line_1010"></div>
                <div id="contact_wrapper">
                    <div class="content_title">For any partnership enquiries, please kindly submit your deal site details through the form below.</div>
                    <div class="contact_form_wrapper_left">

                        <?php if ($hasError) { //If errors are found ?>
                            <div class="content_title error">Please check if you've filled all the fields with valid information. Thank you.</div>
                        <?php } ?>
                        <?php if ($emailSent) { //If email is sent ?>
                            <div class="contact_form_success">Thank you for contacting us, we will get back to you soon.</div>
                        <?php } ?>

                        <?php $this->widget('pages.components.widgets.ContactUs.ContactUs'); ?>

                    </div>
                </div>
                <!-- end of contact_wrapper --> 
            </div>
            <!-- end of about_content -->

            <div class="clear"></div>
        </div>

        <!-- end of about_container --> 
        <?php $this->renderPartial('fragments/footer'); ?>
    </div>
    <!-- end of body_container -->
</div>