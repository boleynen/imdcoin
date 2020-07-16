<?php 

include_once(__DIR__."/c.dbh.php");

class User{
    private $id;
    private $email;
    private $password;
    private $name;
    private $avatar;

    

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

    public function getAllUsers(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("select * from users where email != :email");

        $email = $this->getEmail();
        
        $statement->bindValue(":email", $email);
        
        $statement->execute();
        
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }

    public function getUser(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("select * from users where id like :id");

        $id = $this->getId();
        
        $statement->bindValue(":id", $id);
        
        $statement->execute();
        
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $data;
    }


}

?>