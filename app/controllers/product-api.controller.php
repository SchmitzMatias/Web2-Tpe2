<?php

require_once './app/models/product.model.php';
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

    public function getProducts(){
        $products = $this->model->getAll();
        $this->view->response($products);
    }

    public function getProduct($params = null){
        $id = $params[':id'];

        $product = $this->model->get($id);
        if ($product){
            $this->view->response($product);
        }
        else{
            $this->view->response("El producto con el id=$id no existe",404);
        }
    }

    public function addProduct(){
        $product = $this->getData();

        if (empty($product->name) || empty($product->description) || empty($product->price) || empty($product->id_category_fk)) {
            $this->view->response("Por favor, complete todos los campos", 400);
        }
        else{
            $id = $this->model->insert($product->name,$product->description,$product->price,$product->id_category_fk);
            $product = $this->model->get($id);
            $this->view->response($product,201);
        }
    }

    public function updateProduct($params = null){
        $id = $params[':id'];

        $productValues = $this->getData();
        if (empty($productValues->name) || empty($productValues->description) || empty($productValues->price) || empty($productValues->id_category_fk)) {
            $this->view->response("Por favor, complete todos los campos", 400);
        }

        if($this->model->get($id)){
            $this->model->update($id,$productValues->name, $productValues->description, $productValues->price, $productValues->id_category_fk);
            $product = $this->model->get($id);
            $this->view->response($product);
        }
        else{
            $this->view->response("El producto con el id=$id no existe",404);
        }
    }

    public function deleteProduct($params = null){
        $id = $params[':id'];

        $product = $this->model->get($id); //TODO mejorar esto con try, ahorrando el llamado get
        if($product){
            $this->model->delete($id);
            $this->view->response($product);
        }
        else{
            $this->view->response("El producto con el id=$id no existe",404);
        }
    }

}