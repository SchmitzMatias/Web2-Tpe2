<?php

require_once './app/models/category.model.php';
require_once './app/views/api.view.php';

class CategoryApiController {
    private $model;
    private $view;
    private $data;

    public function __construct(){
        $this->model = new CategoryModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getCategories(){
        if(isset( $_GET['order'])){
            $order = $_GET['order'];
            $categories = $this->model->getAll(strtoupper($order));
        }else{
            $categories = $this->model->getAll();
        }
        $this->view->response($categories);
    }

    public function getCategory($params = null){
        if(isset($params['id'])){
            $id = $params['id'];
            $category = $this->model->get($id);
            if($category){
                $this->view->response($category);
            }else{
                $this->view->response("La categoria con el id=$id no existe");
            }
        }
    }

    public function addCategory(){
        $category = $this->getData();

        if (empty($category->name) || empty($category->description)) {
            $this->view->response("Por favor, complete todos los campos", 400);
        }
        else{
            $id = $this->model->insert($category->name,$category->description);
            $category = $this->model->get($id);
            $this->view->response($category,201);
        }
    }

    public function deleteCategory($params = null){
        $id = $params[':id'];

        $category = $this->model->get($id);
        if($category){
            $this->model->delete($id);
            $this->view->response($category);
        }
        else{
            $this->view->response("La categoria con el id=$id no existe",404);
        }
    }

    public function updateCategory($params = null){
        $id = $params[':id'];

        $categoryValues = $this->getData();
        if (empty($categoryValues->name) || empty($categoryValues->description)) {
            $this->view->response("Por favor, complete todos los campos", 400);
        }

        if($this->model->get($id)){ //valido que exista en la db
            $this->model->update($id,$categoryValues->name, $categoryValues->description);
            $category = $this->model->get($id);
            $this->view->response($category);
        }
        else{
            $this->view->response("La categoria con el id=$id no existe",404);
        }
    }
}