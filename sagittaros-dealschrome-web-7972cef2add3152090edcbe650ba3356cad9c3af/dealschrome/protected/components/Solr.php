<?php

class Solr extends CComponent {

    private $service;

    public function __construct($solrcore) {
        $path = Yii::getPathOfAlias('application.components.SolrPhpClient.Apache.Solr');
        require($path . '/Service.php');

        $this->service = new Apache_Solr_Service('175.41.147.66', '8080', '/dealschrome/' . $solrcore);

        if (!$this->service->ping()) {
            Yii::log('Solr service not responding.', 'error');
            $this->debug('Solr service not responding from AJAX server');
        }
    }

    public function getService() {
        return $this->service;
    }

    public function getDoc() {
        return new Apache_Solr_Document();
    }

    public function query($query = '*:*', $options = array(), $rows = 300, $start = 0) {
        try {
            $solr_response = $this->queryInternal($query, $options, $rows, $start);
            $result = json_decode($solr_response->getRawResponse());
        } catch (Apache_Solr_HttpTransportException $e) {
            $this->debug($e->getMessage(). $e->getTraceAsString() . $e->getResponse()->getRawResponse());
            $result = false;
        }
        return $result;
    }

    protected function queryInternal($query, $options, $rows, $start) {
        $default = array(
            'fl' => '*',
        );
        $params = array_merge($default, $options);
        $solr_response = $this->service->search($query, $start, $rows, $params);

        return $solr_response;
    }

    private function debug($err) {
        mail('felixsagitta@gmail.com', 'AJAX Solr service error', $err);
    }

}

