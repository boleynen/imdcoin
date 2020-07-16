<?php

include_once(__DIR__ . "/c.dbh.php");

class Login{

    private $email;
    private $password;

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
        if(empty($email)){
            throw new Exception("Email mag niet leeg zijn");
        }

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
        if(empty($password)){
            throw new Exception("Paswoord mag niet leeg zijn");
        }

        $this->password = $password;

        return $this;
    }

    public function fetchPassword(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("select password from users where email like :email" );

        $email = $this->getEmail();

        $statement->bindValue(":email", $email);

        $statement->execute();
        
        $passwordVerification = $statement->fetchColumn();
        
        return $passwordVerification;
    }

}


?>