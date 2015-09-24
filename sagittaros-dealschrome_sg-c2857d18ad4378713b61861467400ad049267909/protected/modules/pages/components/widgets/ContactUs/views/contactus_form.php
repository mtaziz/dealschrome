<?php

echo CHtml::beginForm('/pages/default/contactus', 'post', array(
    'id' => "contactform"
));

//first row for name
echo '<div class="contact_form_row">';

echo '<div class="contact_form_title">Name</div>';

echo CHtml::textField("name", "", array(
    'class' => 'required',
));

echo '</div>';

//second row for email
echo '<div class="contact_form_row">';

echo '<div class="contact_form_title">Email</div>';

echo CHtml::textField("email", "", array(
    'class' => 'required email',
));

echo '</div>';

//third row for deal-site name
echo '<div class="contact_form_row">';

echo '<div class="contact_form_title">Deal-site Name</div>';

echo CHtml::textField("dealsite_name", "", array(
    'class' => 'required',
));

echo '</div>';

//fourth row for deal-site link
echo '<div class="contact_form_row">';

echo '<div class="contact_form_title">Deal-site Link</div>';

echo CHtml::textField("dealsite_link", "", array(
    'class' => 'required',
));

echo '</div>';

//fifth row for opearing city
echo '<div class="contact_form_row">';

echo '<div class="contact_form_title">Operating City</div>';

echo CHtml::textField("operating_city", "", array(
    'class' => 'required',
));
echo '</div>';

//sixth row for opearing city
echo '<div class="contact_form_row">';

echo '<div class="contact_form_title">Message/feedback</div>';

echo CHtml::textArea("message", "", array(
    'class' => 'required',
));

echo '</div>';


//submit button
echo '<div class="contact_form_row">';

echo '<div class="contact_form_title">&nbsp;</div>';

echo CHtml::hiddenField('submit','true');

echo CHtml::submitButton("SEND", array(
    'class' => "submit_button"
));

echo '</div>';

echo CHtml::endForm();
?> 