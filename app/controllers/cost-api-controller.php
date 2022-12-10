<?php

require_once './app/models/cost.model.php';
require_once './app/views/api.view.php';

class CostApiController {
    private $model;
    private $view;
    private $data;

    public function __construct(){
        $this->model = new CostModel();
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

        if (empty($cost->item) || empty($cost->amount) || empty($cost->price) || empty($cost->date)) {
            $this->view->response("Por favor, complete todos los campos", 400);
        }
        else{
            $price_unit = ($cost->price/$cost->amount);
            $id = $this->model->insert($cost->item,$cost->amount,$cost->price, $price_unit, $cost->date);
            $cost = $this->model->get($id);
            $this->view->response($cost,201);
        }
    }

    public function updateCost($params = null){
        $id = $params[':id'];

        $cost = $this->model->get($id);
        
        if ($cost){
            $costValues = $this->getData();
            if (empty($costValues)){
                $this->view->response("Por favor, complete algun campo", 400);
            }
            else{
                $price_unit = ($costValues->price/$costValues->amount);
                $this->model->update($id,$costValues->item,$costValues->amount,$costValues->price,$price_unit,$costValues->date);
                $cost = $this->model->get($id);
                $this->view->response($cost);
            }
        }
        else{
            $this->view->response("El costo con el id=$id no existe",404);
        }
    }

    public function deleteCost($params = null){
        $id = $params[':id'];

        $cost = $this->model->get($id);
        if ($cost){
            $this->model->delete($id);
            $this->view->response($cost);
        }
        else{
            $this->view->response("El costo con el id=$id no existe",404);
        }
    }
}