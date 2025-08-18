<?php 

class App{
    public static function make(){
        
try {
$pdo = new PDO('mysql:host=localhost;dbname=volunteer_portal;charset=utf8'
,'root','');
} catch(PDOException $e){
    echo ($e->getMessage());
}
    }
}
