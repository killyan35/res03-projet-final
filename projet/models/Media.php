<?php
class Media {

    // private attribute
    private ?int $id;
    private string $url;
    private string $description;

    // public constructor
    public function __construct(string $url, string $description)
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
    public function getUrl() : string
    {
        return $this->url;
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
    public function setUrl(string $url) : void
    {
        $this->url = $url;
    }
    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }
}
?>