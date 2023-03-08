<?php
class User {

    // private attribute
    private ?int $id;
    private string $username;
    private string $email;
    private string $password;
    private string $role;

    // public constructor
    public function __construct(string $username, string $email, string $password)
    {
        $this->id = null;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    // public getter
    public function getId() : int
    {
        return $this->id;
    }
    public function getUsername() : string
    {
        return $this->username;
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
    
    
    // public setter
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    public function setUsername(string $username) : void
    {
        $this->username = $username;
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
}
?>

