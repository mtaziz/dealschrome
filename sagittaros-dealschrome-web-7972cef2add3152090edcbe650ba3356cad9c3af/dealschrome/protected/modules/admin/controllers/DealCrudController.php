<?php

/* this is solely in ajax, therefore no need to extend poweradmincontroller
 */

class DealCrudController extends CController {

    public function actionUpdateCategory($id, $category) {
        $solr = new Solr('search-engine');
        $solr_arc = new Solr('archive');
        $res = $solr->query('id:"' . $id . '"');
        $oldDoc = (array) $res->response->docs[0];
        $doc = $solr->getDoc();
        
        $doc->id = $id;
        $doc->category = $category;

        foreach($oldDoc as $k=>$v) {
            switch($k) {
                case 'title':
                case 'dealsource':
                case 'price':
                case 'discount':
                case 'worth':
                case 'description':
                case 'imgsrc':
                case 'expiry':
                case 'merchant':
                case 'location':
                case 'bought':
                case 'created':
                    $doc->{$k} = $v;
                    break;
            }
        }

        try {
            $solr->getService()->addDocument($doc);
            $solr->getService()->commit();
            $solr->getService()->optimize();

            $solr_arc->getService()->addDocument($doc);
            $solr_arc->getService()->commit();
            $solr_arc->getService()->optimize();
            echo 'SUCCESS';
        } catch (Exception $e) {
            echo $e->getMessage();
            echo $e->getTrace();
        }

        Yii::app()->end();
    } 

}

