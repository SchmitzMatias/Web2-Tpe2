<?php

require_once './app/models/cost.model.php';
require_once './app/views/api.view.php';

class ProductApiController {
    private $model;
    private $view;
    private $data;

    public function __construct(){
        $this->model = new ProductModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getCosts(){
        $costs = $this->model->getAll();
        $this->view->response($costs);
    }

    public function addCost(){
        $cost = $this->getData();

        if (empty($cost->item) || empty($cost->amount) || empty($cost->price) || empty($cost->price_unit) || empty($cost->date)) {
            $this->view->response("Por favor, complete todos los campos", 400);
        }
        else{
            $id = $this->model->insert($cost->item,$cost->amount,$cost->price,$cost->price_unit, $cost->date);
            $cost = $this->model->get($id);
            $this->view->response($cost,201);
        }
    }


}