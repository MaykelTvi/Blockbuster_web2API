<?php
require_once 'app/views/apiView.php';

abstract class apiController {
    protected $model;
    protected $view;
    private $data;

    public function __construct() {
        $this->view = new APIView();
        $this->data = file_get_contents("php://input");
    }

    function getData(){
        if (!empty($this->data)) {
            return json_decode($this->data);
        } else {
            return null;
        }
    }
}
