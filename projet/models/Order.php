<?php
class Order {
    // private attribute
    private ?int $id;
    private int $address_id;
    private int $user_id;
    private float $total_price;

    // public constructor
    public function __construct(int $address_id, int $user_id, float $total_price)
    {
        $this->id = null;
        $this->address_id = $address_id;
        $this->user_id = $user_id;
        $this->total_price = $total_price;
    }

    // public getter
    public function getId() : int
    {
        return $this->id;
    }
    public function getUser_id() : int
    {
        return $this->user_id;
    }
    public function getAddress_id() : int
    {
        return $this->address_id;
    }
    public function getTotal_price() : float
    {
        return $this->total_price;
    }
    
    // public setter
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    public function setUser_id(int $user_id) : void
    {
        $this->user_id = $user_id;
    }
    public function setAddress_id(int $address_id) : void
    {
        $this->address_id = $address_id;
    }
    public function setTotal_price(float $total_price) : void
    {
        $this->total_price = $total_price;
    }
}
?>