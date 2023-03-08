<?php
class Product {
    // private attribute
    private ?int $id;
    private string $name;
    private string $description;
    private Ingredient $ingredients;
    private int $categoryId;
    private int $size; // formulaire dans le html
    private int $price; // prix de base multiplier par le $size
    private string $slug; // $name avec la fonction slug

    // public constructor
    public function __construct(string $name, string $slug, string $description, int $price)
    {
        $this->id = null;
        $this->name = $name;
        $this->description = $description;
        $this->ingredients = $ingredients;
        $this->categoryId = $categoryId;
        $this->size = $size;
        $this->price = $price;
        $this->slug = $slug;
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
    public function getSlug() : string
    {
        return $this->slug;
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
    public function setSlug(string $slug) : void
    {
        $this->slug = $slug;
    }
}
?>