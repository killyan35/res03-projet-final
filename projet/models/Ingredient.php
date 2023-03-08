<?php
class Category {

    // private attribute
    private ?int $id;
    private string $name;
    private ?string $description;

    // public constructor
    public function __construct(string $name, ?string $description)
    {
        $this->id = null;
        $this->name = $name;
        $this->description = $description;
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
}
?>