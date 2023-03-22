<?php
class Image {

    // private attribute
    private ?int $id;
    private string $url;
    private string $description;
    private int $product_id;

    // public constructor
    public function __construct(?int $id=null, string $url, string $description, int $product_id)
    {
        $this->id = $id;
        $this->url = $url;
        $this->description = $description;
        $this->product_id = $product_id;
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
    public function getProduct_id() : int
    {
        return $this->product_id;
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
    public function setProduct_id(int $product_id) : void
    {
        $this->product_id = $product_id;
    }
    public function toArray() {
      return get_object_vars($this);
    }
}
?>