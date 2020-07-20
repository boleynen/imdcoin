<?php

include_once(__DIR__."/c.dbh.php");

class Signup{
    private $email;
    private $password;
    private $passwordConfirmation;
    private $name;
    private $avatar;
    private $year;
    private $token;
    

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
     * Get the value of passwordConfirmation
     */ 
    public function getPasswordConfirmation()
    {
        return $this->passwordConfirmation;
    }

    /**
     * Set the value of passwordConfirmation
     *
     * @return  self
     */ 
    public function setPasswordConfirmation($passwordConfirmation)
    {
        $this->passwordConfirmation = $passwordConfirmation;

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
     * Get the value of year
     */ 
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set the value of year
     *
     * @return  self
     */ 
    public function setYear($year)
    {
        $this->year = $year;

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

    public static function getEmails(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("select email from users");
        
        $statement->execute();
        
        $emailAdressen = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $emailAdressen;
    }

    public function save(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("insert into users (email, password) 
                                    values (:email, :password)");
        
        $email = $this->getEmail();
        $password = $this->getPassword();
        $password = password_hash($password, PASSWORD_DEFAULT, ["cost" => 14]);
        
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", $password);

        $result = $statement->execute();
        
        return $result;
    }

    public function complete(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("update users set 
                                    name = :name, avatar = :avatar, year = :year, token = :token
                                    where email like :email");
        
        $name = $this->getName();
        $avatar = $this->getAvatar();
        $year = $this->getYear(); 
        $email = $this->getEmail(); 
        $token = $this->getToken(); 
        
        $statement->bindValue(":name", $name);
        $statement->bindValue(":avatar", $avatar);
        $statement->bindValue(":year", $year);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":token", $token);

        $result = $statement->execute();
        
        return $result;
    }


}

?>