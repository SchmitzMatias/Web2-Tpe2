<?php

class CostModel{

    private $db;

    private function connect() {
        $db = new PDO('mysql:host=localhost;'.'dbname=lify_v3;charset=utf8', 'root', '');
        return $db;
    }

    function __construct(){
        $this->db = $this->connect();
    }

    function getFields(){
        $query = 'SHOW columns FROM costs';

        $preparedQuery = $this->db->prepare($query);
        $preparedQuery->execute();

        $fields = $preparedQuery->fetchAll(PDO::FETCH_COLUMN);
        return $fields;
    }

    function getAll(){
        $query = 'SELECT * from costs';

        $preparedQuery = $this->db->prepare($query);
        $preparedQuery->execute();

        $costs = $preparedQuery->fetchAll(PDO::FETCH_OBJ);
        return $costs;
    }

    function get($id){
        $query = $this->db->prepare('SELECT * from costs WHERE id= ?');
        $query->execute([$id]);

        $cost = $query->fetch(PDO::FETCH_OBJ);

        return $cost;
    }
    
    function insert($item, $amount, $price, $price_unit, $date){
        $query = $this->db->prepare('INSERT INTO costs (item, amount, price, price_unit, date) VALUES(?,?,?,?,?)');
        $query->execute([$item, $amount, $price, $price_unit, $date]);

        return $this->db->lastInsertId();
    }

    function delete($id) {
        $query = $this->db->prepare('DELETE FROM costs WHERE id = ?');
        $query->execute([$id]);
    }

    function update($id, $item, $amount, $price, $price_unit, $date){
        $query = $this->db->prepare('UPDATE costs SET item = ? , amount = ? , price = ? , price_unit = ? , date = ? WHERE id = ? ');
        $query->execute([$item, $amount, $price, $price_unit, $date, $id]);
    }
}