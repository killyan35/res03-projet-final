<?php
class Category {

    // private attribute
    private ?int $id;
    private string $name;
    private ?string $imgURL;
    private string $slug;

    // public constructor
    public function __construct(string $name, ?string $imgURL)
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
}
?>