<?php

class DealCategoryChanger extends CWidget {

    public $dealUrl;

    public function run() {
        if (Yii::app()->user->isGuest)
            return;
        $powerAdmin = array('sagittaros', 'yiseng', 'yugene');
        $username = Yii::app()->user->id;
        if (in_array($username, $powerAdmin)) {
            $solr = new Solr('search-engine');
            $res = $solr->query('id:"' . $this->dealUrl . '"');
            $docs = $res->response->docs;
            if (array_key_exists(0, $docs)) {
                $options = array(
                    'Eateries' => 'Eateries',
                    'Fun & Activities' => 'Fun & Activities',
                    'Beauty & Wellness' => 'Beauty & Wellness',
                    'Goods' => 'Goods',
                    'Services & Others' => 'Services & Others',
                    'Travel' => 'Travel',
                );
                $ajaxScript = <<<"EOD"
jQuery.get('/admin/dealCrud/updateCategory',
    {'id':'{$this->dealUrl}','category':jQuery(this).val()},
    postUpdateCategoryAction
); 

function postUpdateCategoryAction(data) {
    if(data == 'SUCCESS'){
        console.log("success");
        alert('success');
    } else {
        console.log(data);
        alert("update failed");
    }
}

EOD;
                $htmlOptions = array(
                    'onchange' => $ajaxScript,
                );
                echo CHtml::dropDownList(
                        'category', $res->response->docs[0]->category_raw, $options, $htmlOptions);
            }
        }
    }

}

