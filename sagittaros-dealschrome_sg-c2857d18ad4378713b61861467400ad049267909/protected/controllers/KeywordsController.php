<?php

class KeywordsController extends PowerAdminController {

    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionCategory($category_id) {

        $category_name = strtoupper(KeywordCategory::model()->findByPk($category_id)->name);
        $content = "<h1>{$category_name}</h1>";
        $content .= $this->renderPartial('create_subcategory', array('category_id' => $category_id), TRUE);

        $subcategories = $this->getSubcategories($category_id);
        foreach ($subcategories as $s) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'subcategory=:subcategory';
            $criteria->params = array(':subcategory' => $s->id);
            $criteria->order = "term";
            //dd($criteria);
            $terms = Keyword::model()->findAll($criteria);
            $terms_list = '';
            foreach ($terms as $term) {
                $terms_list .= $this->renderPartial('term', array(
                    'term' => $term,
                    'subcategories' => $this->simplifySubcategories($subcategories),
                    'subcategory' => $s,
                    'category_id' => $category_id), TRUE);
            }
            $content .= $this->renderPartial('subcategory_block', array(
                "termList" => $terms_list,
                "category_id" => $category_id,
                "subcategory" => $s), TRUE);
        }

        $this->renderText($content);
    }

    public function actionAjaxCreate() {
        if (isset($_POST['term']) && isset($_POST['subcategory-id']) && $_POST['passcode'] == 'u98u8aUIUOa8scja89sjcjGBHJ') {
            $model = new Keyword;
            if (Keyword::model()->findByAttributes(array('term' => $_POST['term']))) {
                $failure = 0;
                echo $failure;
            } else {
                $model->term = $_POST['term'];
                $model->subcategory = $_POST['subcategory-id'];
                $model->category = $_POST['category-id'];
                $model->weight = 1;
                $model->save();
                $subcategories = $this->simplifySubcategories($this->getSubcategories($_POST['category-id']));
                $success = 1;
                echo $success . $this->renderPartial('term', array(
                        'term' => $model,
                        'subcategories' => $subcategories,
                        'subcategory' => KeywordSubcategory::model()->findByPk($model->subcategory),
                        'category_id' => $model->category), TRUE,TRUE);
            }
        }
        Yii::app()->end();
    }

    public function actionAjaxUpdate($termId, $subCategory, $passcode) {
        if ($passcode == 'a12(87878eu8u8j)iaOp*9sjc') {
            Keyword::model()->updateByPk($termId, array('subcategory' => $subCategory));
            echo json_encode(array('termId' => $termId, 'subcategory' => $subCategory));
        }
        Yii::app()->end();
    }

    /**
     * called by an ajax form
     * input is $_POST['id'] 
     */
    public function actionAjaxDelete() {
        if (isset($_POST['id']) && isset($_POST['passcode']) && $_POST['passcode'] == 'u98u8acja8scja89sjcjGBHJ') {
            Keyword::model()->deleteByPk($_POST['id']);
        }
        Yii::app()->end();
    }
    
    protected function getSubcategories($category_id) {
        $subcategories = KeywordSubcategory::model()
                ->findAllByAttributes(array("category" => $category_id));
        
        return $subcategories;
    }
    
    protected function simplifySubcategories($subcategories) {
        $container = array();
        foreach($subcategories as $s) {
            $container[$s->id] = $s->name;
        }
        return $container;
    }

}