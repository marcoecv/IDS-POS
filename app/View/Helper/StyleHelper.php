<?php
App::uses('AppHelper', 'View/Helper');

class StyleHelper extends AppHelper {
    public function getTemplateAgent() {
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $doc = $this->request->query["doc"];
        $detailTemplate = array();
        return $detailTemplate;
	}   
}