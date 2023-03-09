<?php
class User {

    // private attribute
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private string $role;
    private int $billingId;

    // public constructor
    public function __construct(string $firstname, string $lastname, string $email, string $password, string $role, int $billingId)
    {
        $this->id = null;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->billingId = $billingId;
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
    public function getBillingId() : int
    {
        return $this->billingId;
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
    public function setBillingId(int $billingId) : void
    {
        $this->billingId = $billingId;
    }
}
?>

