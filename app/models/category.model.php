<?php

class CategoryModel{

    private $db;

    private function connect() {
        $db = new PDO('mysql:host=localhost;'.'dbname=lify;charset=utf8', 'root', '');
        return $db;
    }

    function __construct(){
        $this->db = $this->connect();
    }

    function getAll($order = 'ASC'){
        $query = 'SELECT * from categories';
        
        if($order == 'DESC' || $order == 'ASC'){
            $query = $query . ' ORDER BY name ' . $order;
        }

        $preparedQuery = $this->db->prepare($query);
        $preparedQuery->execute();

        $categories = $preparedQuery->fetchAll(PDO::FETCH_OBJ);
        return $categories;
    }

    function get($id){
        $query = $this->db->prepare('SELECT * from categories WHERE id= ?');
        $query->execute([$id]);

        $category = $query->fetch(PDO::FETCH_OBJ);

        return $category;
    }
    
    function insert($name,$description){
        $query = $this->db->prepare('INSERT INTO categories (name,description) VALUES(?,?)');
        $query->execute([$name,$description]);

        return $this->db->lastInsertId();
    }

    function delete($id) {
        $query = $this->db->prepare('DELETE FROM categories WHERE id = ?');
        $query->execute([$id]);
    }

    function update($id,$name,$description){
        $query = $this->db->prepare('UPDATE categories SET name = ? , description = ? WHERE id = ? ');
        $query->execute([$name,$description,$id]);
    }
}