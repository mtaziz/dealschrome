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
                    <li><a class="green" href="<?php echo $this->createUrl('/pages/default/aboutus'); ?>">About Us</a></li>
                    <li><a href="<?php echo $this->createUrl('/pages/default/contactus'); ?>">Contact Us</a></li>
                    <li><a href="<?php echo $this->createUrl('/pages/default/faq'); ?>">FAQ</a></li>
                    <li><a href="<?php echo $this->createUrl('/pages/default/terms'); ?>">Terms</a></li>

                    <li><a href="<?php echo $this->createUrl('/pages/default/privacy'); ?>">Privacy Policy</a></li>

                </ul>
            </div>

            <!-- end of about_wrapper -->

            <div class="about_content">
                <h2>About Us</h2>
                <br>
                <h4>What is DealsChrome?</h4>
                DealsChrome helps you to discover the best deals easily by liaising with our technology, 
                we enhance your experience in finding out the best deals in your city. <br>
                <br>
                Besides, Deals89 is a proprietary of Storepair Lte.Ltd - a locational social 
                commerce directory that connects businesses and customers. 
                We are working on the idea and plan to become the future of social commerce. <br>
                <br>
                <h4>Contact Us</h4>
                Feel free to email us at <a href="mailto:support@dealschrome.com"> support@dealschrome.com</a> for any enquiries. <br>
                <br>
                Kindly follow us on <a target="_blank" href="https://www.facebook.com/pages/DealsChrome-Discover-Daily-Deal/265243100195058">facebook</a>, <a target="_blank" href="https://plus.google.com/111133570718388353473">Google+</a>, <a target="_blank" href="http://twitter.com/dealschrome">Twitter</a> and <a target="_blank" href="http://foursquare.com/dealschrome">Foursquare</a> for our latest updates. <br>
                <br>

            </div>
            <!-- end of about_content -->

            <div class="clear"></div>
        </div>

        <!-- end of about_container --> 
        <?php $this->renderPartial('fragments/footer'); ?>
    </div>
    <!-- end of body_container -->
</div>