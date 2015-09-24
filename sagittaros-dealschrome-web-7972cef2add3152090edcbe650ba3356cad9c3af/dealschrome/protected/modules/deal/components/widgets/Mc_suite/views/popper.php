<div id="popper-wrapper">    
    <div id="popper"> <a class="deals-popup-close-button" title="already subscribed">X</a>
        <div class="deals-subscribe-text">
            <div class="popper_logo"><img src="http://dealschrome.com/themes/chrome/images/DealsChrome_logo_1.png" /></div>
            <div class="deals-subscribe-title">Don't miss a single news from us</div>
            <div class="deals-subscribe-intro"> From food to fun, DealsChrome is a great place for you to discover deals that you love. Subscribe now to receive unbeatable updates from us straight to your inbox. <br />
                <div class="small_note">We hate spam too, so don't worry about that.</div>
            </div>
            <div class="deals-popup-email-bar">

                <?php $this->widget('pages.components.widgets.MailChimp.MailChimp'); ?>
                <div class="clear"></div>
                <div class="error"  style="display:none;">Please enter a valid email address.</div>
            </div>
        </div>
        <!-- end of deals-subscribe-text --> 
    </div>
</div>
<div class="clear"></div>