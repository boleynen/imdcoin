<?php 

include_once(__DIR__."/c.dbh.php");

class User{
    private $id;
    private $email;
    private $password;
    private $name;
    private $avatar;
    private $currency;
    private $token;

    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of avatar
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }
    
    /**
     * Get the value of currency
     */ 
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @return  self
     */ 
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    
    public function getAllUsers(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("select * from users where email != :email");

        $email = $this->getEmail();
        
        $statement->bindValue(":email", $email);
        
        $statement->execute();
        
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }

    public function getMyData(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("select * from users where email like :email");

        $email = $this->getEmail();
        
        $statement->bindValue(":email", $email);
        
        $statement->execute();
        
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }

    public function getUser(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("select name from users where id like :id");

        $id = $this->getId();
        
        $statement->bindValue(":id", $id);
        
        $statement->execute();
        
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }

    public function getUserAvatar(){

        $conn = Database::getConnection();
        
        $statement = $conn->prepare("select avatar from users where id like :id");

        $id = $this->getId();
        
        $statement->bindValue(":id", $id);
        
        $statement->execute();
        
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }


    function searchMatch($query) {
        $conn = Database::getConnection();
        
        $stmt = $conn->prepare($query);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;

    }
    

    public function getFreeCoins(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("update users set 
                                    currency = :currency
                                    where email like :email");
        
        $currency = $this->getCurrency(); 
        $email = $this->getEmail(); 
        
        $statement->bindValue(":currency", $currency);
        $statement->bindValue(":email", $email);

        $result = $statement->execute();
        
        return $result;
    }

    public function checkToken(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("SELECT token FROM users WHERE email like :email");

        $email = $this->getEmail();
        
        $statement->bindValue(":email", $email);
        
        $statement->execute();
        
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }

    public function updateToken(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("UPDATE users SET token = :token WHERE email = :email");

        $token = $this->getToken();
        $email = $this->getEmail();
        
        $statement->bindValue(":token", $token);
        $statement->bindValue(":email", $email);
        
        $statement->execute();
        
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }


}

?>