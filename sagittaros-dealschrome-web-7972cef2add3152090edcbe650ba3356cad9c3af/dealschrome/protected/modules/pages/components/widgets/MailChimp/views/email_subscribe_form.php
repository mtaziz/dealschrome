<?php

echo CHtml::beginForm('/pages/utilities/mailchimp','post',array(
    'id' => "mc-embedded-subscribe-form"
));
echo '<div class="deals-location-selector-container">';

echo CHtml::textField("email", "enter email to subscribe", array(
    'class' => 'overlay_email  email',
    'id' => 'mce-EMAIL',
    'onclick' => "if(!this._haschanged){this.value=''};this._haschanged=true;",
));
echo CHtml::submitButton("submit", array(
    'id' => "mc-embedded-subscribe",
    'class' => "overlay_subscribe"
));
echo '</div>';
echo CHtml::endForm();

?>