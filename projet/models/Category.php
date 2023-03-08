<?php
class Category {

    // private attribute
    private ?int $id;
    private string $name;
    private ?string $description;
    private string $slug;

    // public constructor
    public function __construct(string $name, ?string $description, string $slug)
    {
        $this->id = null;
        $this->name = $name;
        $this->description = $description;
        $this->slug = $slug;
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
    public function setSlug(string $slug) : void
    {
        $this->slug = $slug;
    }
}
?>