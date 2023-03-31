<?php
class User {

    // private attribute
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private string $role;
    private ?int $address_id;

    // public constructor
    public function __construct(?int $id=null, string $firstname, string $lastname, string $email, string $password, ?int $address_id=null)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = "USER";
        $this->address_id = $address_id;
    }

    // public getter
    public function getId() : int
    {
        return $this->id;
    }
    public function getFirstname() : string
    {
        return $this->firstname;
    }
    public function getLastname() : string
    {
        return $this->lastname;
    }
    public function getEmail() : string
    {
        return $this->email;
    }
    public function getPassword() : string
    {
        return $this->password;
    }
    public function getRole() : string
    {
        return $this->role;
    }
    public function getAddress_id() : int
    {
        return $this->address_id;
    }
    
    // public setter
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    public function setFirstname(string $firstname) : void
    {
        $this->username = $username;
    }
    public function setLastname(string $lastname) : void
    {
        $this->lastname = $lastname;
    }
    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }
    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }
    public function setRole(string $role) : void
    {
        $this->role = $role;
    }
    public function setAddress_id(int $address_id) : void
    {
        $this->address_id = $address_id;
    }
}
?>

