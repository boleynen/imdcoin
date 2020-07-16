<?php 

class Database{

    private static $conn;

    public static function getConnection(){

        include_once(__DIR__."/../settings.php");

        if(self::$conn === null){
            self::$conn = new PDO("mysql:host=" . SETTINGS["db"]["host"] . "; dbname=" . SETTINGS["db"]["dbname"], SETTINGS["db"]["user"], SETTINGS["db"]["password"] );
        
            return self::$conn;             
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }
              echo "Connected successfully";
        }
        else{
            return self::$conn;

        }
    }
}








?>