<?php
class Category {

    // private attribute
    private ?int $id;
    private string $name;
    private string $imgURL;
    private string $slug;

    // public constructor
    public function __construct(string $name, string $imgURL)
    {
        $this->id = null;
        $this->name = $name;
        $this->imgURL = $imgURL;
        $this->slug = $this->slugify($name);
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
    public function getImgURL() : string
    {
        return $this->imgURL;
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
    public function setImgURL(string $imgURL) : void
    {
        $this->imgURL = $imgURL;
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