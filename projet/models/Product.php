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
    public function __construct(string $name, string $description, int $price, int $categoryId)
    {
        $this->id = null;
        $this->name = $name;
        $this->slug = $this->slugify($name);
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
    
    
    public function slugify($text, string $divider = '-')
        {
          // replace non letter or digits by divider
          $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        
          // transliterate
          $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
          // remove unwanted characters
          $text = preg_replace('~[^-\w]+~', '', $text);
        
          // trim
          $text = trim($text, $divider);
        
          // remove duplicate divider
          $text = preg_replace('~-+~', $divider, $text);
        
          // lowercase
          $text = strtolower($text);
        
          if (empty($text)) {
            return 'n-a';
          }
        
          return $text;
        }
}
?>