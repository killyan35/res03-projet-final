<?php
class Ingredient {

    // private attribute
    private ?int $id;
    private string $name;

    // public constructor
    public function __construct(string $name)
    {
        $this->id = null;
        $this->name = $name;
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
    
    // public setter
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    public function setName(string $name) : void
    {
        $this->name = $name;
    }
}
?>