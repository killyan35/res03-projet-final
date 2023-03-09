<?php
class Product {
    // private attribute
    private ?int $id;
    private string $name;
    private string $slug; // $name avec la fonction slug
    private string $description;
    private int $price;
    private int $categoryId; // formulaire dans le html
 
    // public constructor
    public function __construct(string $name, string $slug, string $description, int $price, int $categoryId)
    {
        $this->id = null;
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
        $this->price = $price;
        $this->categoryId = $categoryId;
    }

    // public getter
    public function getId() : int
    {
        return $this->id;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getDescription() : string
    {
        return $this->description;
    }
    public function getCategoryId() : int
    {
        return $this->categoryId;
    }
    public function getPrice() : int
    {
        return $this->price;
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
    public function setName(string $name) : void
    {
        $this->name = $name;
    }
    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }
    public function setCategoryId(int $categoryId) : void
    {
        $this->categoryId = $categoryId;
    }
    public function setPrice(int $price) : void
    {
        $this->price = $price;
    }
    public function setSlug(string $slug) : void
    {
        $this->slug = $slug;
    }
}
?>