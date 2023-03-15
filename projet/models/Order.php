<?php
class Order {
    // private attribute
    private ?int $id;
    private int $size; // formulaire dans le html
    private int $number; // formulaire dans le html
    private int $totalPrice; // prix de base multiplier par le $size et le $number
    private int $userId;
    private int $billingId;
    private int $totalOrderPrice;

    // public constructor
    public function __construct(int $billingId, int $size, int $number, ?int $totalPrice=null, int $userId)
    {
        $this->id = null;
        $this->userId = $userId;
        $this->size = $size;
        $this->number = $number;
        $this->totalPrice = $totalPrice;
        $this->billingId = $billingId;
        if($totalPrice===null)
        {
            $this->totalPrice = $this->slugify($name);
        }
        else
        {
            $this->totalPrice = $totalPrice;
        }
        if($totalOrderPrice===null)
        {
            $this->totalOrderPrice = $this->slugify($name);
        }
        else
        {
            $this->totalOrderPrice = $totalOrderPrice;
        }
    }

    // public getter
    public function getId() : int
    {
        return $this->id;
    }
    public function getUserId() : int
    {
        return $this->userId;
    }
    public function getSize() : int
    {
        return $this->size;
    }
    public function getNumber() : int
    {
        return $this->number;
    }
    public function getTotalPrice() : int
    {
        return $this->totalPrice;
    }
    public function getBillingId() : int
    {
        return $this->billingId;
    }
    
    // public setter
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    public function setUserId(int $userId) : void
    {
        $this->userId = $userId;
    }
    public function setSize(int $size) : void
    {
        $this->size = $size;
    }
    public function setNumber(int $number) : void
    {
        $this->number = $number;
    }
    public function setTotalPrice(int $totalPrice) : void
    {
        $this->totalPrice = $totalPrice;
    }
    public function setBillingId(int $billingId) : void
    {
        $this->billingId = $billingId;
    }
    
    
    
    private function calculTotalPrice(int $number, int $size, int $price) 
    {
        $totalprice = ($price*$size)*$number;
        return $totalprice;
    }
    
    private function calculTotalOrderPrice(int $number, int $totalprice)
    {
        
    }
}
?>