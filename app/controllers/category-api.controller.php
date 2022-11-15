<?php

require_once './app/models/category.model.php';
require_once './app/views/api.view.php';
require_once './app/helpers/auth-api.helper.php';

class CategoryApiController {
    private $model;
    private $view;
    private $authHelper;
    private $data;
    
    public function __construct(){
        $this->model = new CategoryModel();
        $this->view = new ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->data = file_get_contents("php://input");
        
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getCategories(){
        $sortBy = "name";
        $order= "ASC";
        $limit = 10;
        $page=1;
        $offset = 0;
        $filterBy = null;

        if(isset($_GET['sortBy']) && !empty($_GET['sortBy'])){
            $input = strtolower($_GET['sortBy']);
            if(in_array($input,$this->model->getFields())){
                $sortBy = $input;
            }else{
                $this->view->response($input . ": No es un campo valido",400);
                die();
            }
        }

        if(isset($_GET['order']) && !empty($_GET['order'])){
            $input = strtoupper($_GET['order']);
            if ($input == "ASC" | $input == "DESC"){
                $order = $input;
            }else{
                $this->view->response($input . ": No es un orden valido",400);
                die();
            }
        }

        if(isset($_GET['limit']) && !empty($_GET['limit'])){
            $input = $_GET['limit'];
            if(is_numeric($input) && $input>0){
                $limit = $input;
            }else{
                $this->view->response($input . ": No es un limite valido", 400);
                die();
            }
        }

        if (isset($_GET['page']) && !empty($_GET['page'])){
            $input = $_GET['page'];
            if(is_numeric($input) && $input>0){
                $page = $input;
                $offset = ($page - 1) * $limit;
            }else{
                $this->view->response($input . ": No es una pagina valida", 400);
                die();
            }
        }

        if (isset($_GET['filterBy']) && !empty($_GET['filterBy']) && isset($_GET['value']) && !empty($_GET['value'])){
            $filterBy = strtolower($_GET['filterBy']);
            $value = strtolower($_GET['value']);

            if (in_array($filterBy,$this->model->getFields())){
                $categories = $this->model->getByFieldValue($filterBy, $value);
                $this->view->response($categories,200);
                die();
            }else{
                $this->view->response($filterBy . ": No es un campo valido", 400);
                die();
            }
        }

        $categories = $this->model->getAll($sortBy, $order, $limit, $offset);
        $this->view->response($categories);
    }

    public function getCategory($params = null){
        if(isset($params[':id'])){
            $id = $params[':id'];
            $category = $this->model->get($id);
            if($category){
                $this->view->response($category);
            }else{
                $this->view->response("La categoria con el id=$id no existe");
            }
        }
    }

    public function addCategory(){
        
        if(!$this->authHelper->isLoggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

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

    public function updateCategory($params = null){

        if(!$this->authHelper->isLoggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        $id = $params[':id'];

        $categoryValues = $this->getData();
        if (empty($categoryValues->name) || empty($categoryValues->description)) {
            $this->view->response("Por favor, complete todos los campos", 400);
        }

        if($this->model->get($id)){
            $this->model->update($id,$categoryValues->name, $categoryValues->description);
            $category = $this->model->get($id);
            $this->view->response($category);
        }
        else{
            $this->view->response("La categoria con el id=$id no existe",404);
        }
    }

    public function deleteCategory($params = null){

        if(!$this->authHelper->isLoggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        $id = $params[':id'];

        $category = $this->model->get($id);
        if($category){
            try{
                $this->model->delete($id);
                $this->view->response($category);
            }
            catch(PDOException){
                $this->view->response("La categoria seleccionada tiene productos asociados y no puede ser borrada");
            }
        }
        else{
            $this->view->response("La categoria con el id=$id no existe",404);
        }
    }

    public function default(){
        $this->view->response("Pagina no encontrada, compruebe la url",404);
    }

}