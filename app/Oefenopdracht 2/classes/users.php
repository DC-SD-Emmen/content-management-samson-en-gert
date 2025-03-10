<?php

 
class users {
    
    private $id;
    private $username;
    private $emailaddress;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setEmailaddress($emailaddress)
    {
        $this->emailaddress = $emailaddress;
    }

    public function getEmailaddress()
    {
        return $this->emailaddress;
    }
}
?>
