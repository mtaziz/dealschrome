<?php

class KeywordsSolrController extends PowerAdminController {

    public function actionIndex() {
        $solr = new Solr('deal-category');
        $solr->getService()->deleteByQuery('*:*');

        $cats = KeywordCategory::model()->findAll();
        $allkeywords = '';

        foreach ($cats as $c) {
            $sql = "select term from Keyword where category = {$c->id}";
            $command = Yii::app()->db->createCommand($sql);
            $rows = $command->queryColumn();
            $doc = $solr->getDoc();
            $doc->id = trim($c->name);
            $doc->keywords = implode(" ", $rows);
            $allkeywords .= $doc->keywords . ' ';
            d($doc);
            $solr->getService()->addDocument($doc);
        }

        $doc = $solr->getDoc();
        $doc->id = "Services & Others";
        $doc->keywords = $allkeywords;
        $solr->getService()->addDocument($doc);

        $solr->getService()->commit();
        $solr->getService()->optimize();
        $this->render('index');
    }

}