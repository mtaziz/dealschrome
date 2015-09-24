<?php

/**
 * This is the model class for table "TopSearch".
 *
 * The followings are the available columns in table 'TopSearch':
 * @property string $id
 * @property string $search
 * @property string $frequency
 * @property string $period
 */
class TopSearch extends CActiveRecord {

    public static function saveTermOld($term) {
        $found = static::model()->find('search=:term', array(':term' => $term));
        if ($found) {
            $found->frequency++;
            $found->save();
        } else {
            $newTerm = new TopSearch;
            $newTerm->period = round(time() / (86400 * 30));
            $newTerm->frequency = 1;
            $newTerm->search = $term;
            $newTerm->save();
        }
    }

    public static function saveTerm($term) {
        $foundExact = static::model()->find('search=:term', array(
            ':term' => $term));
        $foundLonger = Yii::app()->db->createCommand()
                ->select()
                ->from('TopSearch')
                ->where(array('like','search',"$term%"))
                ->queryRow();
        $foundShorter = static::model()->find('search=:truncated', array(
            ':truncated' => substr($term, 0, strlen($term) - 1)));
        if ($foundExact) {
            $foundExact->frequency++;
            $foundExact->save();
            return;
        }
        if ($foundLonger && $foundShorter){
            $foundShorter->delete();
        }
        
        if ($foundLonger) {
            return;
        }
        if ($foundShorter) {
            $foundShorter->frequency = 1;
            $foundShorter->search = $term;
            $foundShorter->save();
            return;
        }
        
        $newTerm = new TopSearch;
        $newTerm->period = round(time() / (86400 * 30));
        $newTerm->frequency = 1;
        $newTerm->search = $term;
        $newTerm->save();
    }

    public static function getTopTerms($limit) {
        $criteria = new CDbCriteria();
        $thisperiod = round(time() / (86400 * 30));
        $thisperiod--; // find the last period one
        $condition = "`search` NOT LIKE '%*%' AND `search` NOT LIKE '%:%' AND `period` = $thisperiod";
        $criteria->select = 'search';
        $criteria->condition = $condition;
        $criteria->order = 'frequency DESC';
        $num = $limit * 2;
        $criteria->limit = $num;
        $tops = static::model()->findAll($criteria);
        $returns = array();
        $dealModel = new DealModel();
        foreach ($tops as $t) {
            $exists = $dealModel->isTermExists($t->search);
            if($exists && strlen($t->search)< 13){
                $returns[] = $t->search;
            }
        }
        return array_slice($returns,0,$limit);
    }

    /*     * ****************************************** */

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TopSearch the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'TopSearch';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('search, frequency, period', 'required'),
            array('search', 'length', 'max' => 255),
            array('frequency, period', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, search, frequency, period', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'search' => 'Search',
            'frequency' => 'Frequency',
            'period' => 'Period',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('search', $this->search, true);
        $criteria->compare('frequency', $this->frequency, true);
        $criteria->compare('period', $this->period, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}