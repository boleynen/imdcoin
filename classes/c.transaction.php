<?php

include_once(__DIR__."/c.dbh.php");

class Transaction{
    private $id;
    private $sender;
    private $receiver;
    private $amount;
    private $reason;
    private $date;


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
     * Set the value of sender
     *
     * @return  self
     */ 
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get the value of receiver
     */ 
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set the value of receiver
     *
     * @return  self
     */ 
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of reason
     */ 
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set the value of reason
     *
     * @return  self
     */ 
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function pay(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("insert into transactions 
                                    (sender, receiver, amount, reason, date) 
                                    values 
                                    (:sender, :receiver, :amount, :reason, :date)");
        
        $sender = $this->getSender();
        $receiver = $this->getReceiver();
        $amount = $this->getAmount();
        $reason = $this->getReason();
        $date = $this->getDate();
        
        $statement->bindValue(":sender", $sender);
        $statement->bindValue(":receiver", $receiver);
        $statement->bindValue(":amount", $amount);
        $statement->bindValue(":reason", $reason);
        $statement->bindValue(":date", $date);

        $result = $statement->execute();
        
        return $result;
    }

    public function getTransactions(){
        $conn = Database::getConnection();
        
        $statement = $conn->prepare("select * from transactions 
                                     where 
                                     receiver like :id 
                                     or 
                                     sender like :id");

        $id = $this->getId();
        
        $statement->bindValue(":id", $id);
        
        $statement->execute();
        
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }
}

?>