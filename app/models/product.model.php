<?php

class ProductModel{

    private $db;

    private function connect() {
        $db = new PDO('mysql:host=localhost;'.'dbname=lify_v3;charset=utf8', 'root', '');
        return $db;
    }

    function __construct(){
        $this->db = $this->connect();
    }

    function getAll(){
        $query = $this->db->prepare('SELECT p.id , p.name, p.description, p.price, c.name as category from products p INNER JOIN categories c ON p.id_category_fk = c.id');
        $query->execute();

        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }

    function get($id){
        $query = $this->db->prepare('SELECT p.id , p.name, p.description, p.price, p.id_category_fk, c.name as category from products p INNER JOIN categories c ON p.id_category_fk = c.id WHERE p.id=?');
        $query->execute([$id]);

        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }

    function getAllByCategoryId($categoryId){
        $query = $this->db->prepare('SELECT p.id, p.name, p.description, p.price, c.name as category from products p INNER JOIN categories c ON p.id_category_fk = c.id
        WHERE p.id_category_fk = ?');
        $query->execute([$categoryId]);

        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }
    
    function insert($name,$description,$price,$category){
        $query = $this->db->prepare('INSERT INTO products (name,description,price,id_category_fk) VALUES(?,?,?,?)');
        $query->execute([$name,$description,$price,$category]);

        return $this->db->lastInsertId();
    }

    function update($id,$name,$description,$price,$category){
        $query = $this->db->prepare('UPDATE products SET name = ? , description = ? , price = ? , id_category_fk = ? WHERE id = ? ');
        $query->execute([$name,$description,$price,$category,$id]);
    }

    function delete($id) {
        $query = $this->db->prepare('DELETE FROM products WHERE id = ?');
        $query->execute([$id]);
    }

}