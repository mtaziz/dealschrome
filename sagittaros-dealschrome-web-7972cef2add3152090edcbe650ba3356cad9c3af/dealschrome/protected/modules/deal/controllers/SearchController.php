<?php

class SearchController extends DealController {

    public $defaultAction = 'simple';
    public $layout = '//layouts/html';

    public function actionSimple() {
        $this->pageTitle = "DealsChrome - Best Deals in One Click";
        $model = new DealModel;
        $found = $model->getTotalDeals();
        $this->render('page_home', array(
            'found' => $found,
        ));
    }

    public function actionAjaxFullBody() {
        AssetLoader::load($this->viewPath . '/scripts/depagify.js');
        AssetLoader::load($this->viewPath . '/scripts/gobacktop_button.js');
        $this->renderPartial('page_listing',NULL,false,true);
    }

    public function actionAjaxload() {
        $is_urlencoded = TRUE;
        $params = $this->resolve_request_vars($is_urlencoded);
        extract($params);

        $solr = new DealModel;
        try {
            $solr_data = $solr->queryWithSpellCheck($query, $query_options, $rows, $offset);
            $solr_result = $solr_data->response;
        } catch (Exception $e) {
            $solr_result = NULL;
            //echo $e->getMessage();
            return;
        }

        foreach ($solr_result->docs as $d) {
            $d = DealProcessor::process($d);
        }

        echo json_encode(
                array(
                    "numFound" => $solr_result->numFound,
                    "docs" => $solr_result->docs,
                )
        );

        Yii::app()->end();
    }

    public function actionAjaxSuggestion() {
        if (isset($_REQUEST['term'])) {
            $term = $_REQUEST['term'];
        } else {
            echo json_encode(array());
            return;
        }

        $termset = preg_split('#\W#', $term);
        $termset = array_values(array_filter($termset, function($var) {
                            return $var;
                        }));

        if (!count($termset)) {
            echo json_encode(array());
            return;
        }

        $term = $termset[0];

        $solr = new DealModel;

        try {
            $response = $solr->getSuggestions($term);
        } catch (Exception $e) {
            $response = NULL;
            dd($e->getMessage());
        }
        array_shift($termset);

        $result = array();

        foreach ($response as $r) {
            $found = TRUE;
            foreach ($termset as $t) {
                if (strpos($r, $t) == FALSE) {
                    $found = FALSE;
                    break;
                }
            }
            if ($found) {
                $result[] = $r;
            }
        }
        echo json_encode($result);
        Yii::app()->end();
    }

    public function actionLocationDeals($center, $radius) {
        $solr = new DealModel;
        try {
            $solr_result = $solr->getDealsFromLocation($center, $radius);
        } catch (Exception $e) {
            echo "unable to query deals from location";
        }
        echo json_encode($solr_result);
        Yii::app()->end();
    }

}