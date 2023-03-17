<?php
class Order {
    // private attribute
    private ?int $id;
    private int $size; // formulaire dans le html
    private int $number; // formulaire dans le html
    private int $totalPiece; // prix de base multiplier par le $size et le $number
    private int $userId;
    private int $billingId;
    private float $totalOrderPrice;

    // public constructor
    public function __construct(int $billingId, int $size, int $number, int $totalPiece, int $userId, float $totalOrderPrice)
    {
        $this->id = null;
        $this->userId = $userId;
        $this->size = $size;
        $this->number = $number;
        $this->totalPrice = $totalPrice;
        $this->billingId = $billingId;
        $this->totalPiece = $this->calculTotalPiece($number,$size);
        $this->totalOrderPrice = $this->calculTotalOrderPrice($number,$totalPrice);
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
    public function getTotalPiece() : int
    {
        return $this->totalPrice;
    }
    public function getBillingId() : int
    {
        return $this->billingId;
    }
    public function getTotalOrderPrice() : float
    {
        return $this->totalOrderPrice;
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
    public function setTotalPiece(int $totalPiece) : void
    {
        $this->totalPiece = $totalPiece;
    }
    public function setBillingId(int $billingId) : void
    {
        $this->billingId = $billingId;
    }
    public function setTotalOrderPrice(float $totalOrderPrice) : void
    {
        $this->totalOrderPrice = $totalOrderPrice;
    }
    
    
    
    private function calculTotalPiece(int $number, int $size) : int
    {
        $totalpiece = $size*$number;
        return $totalpiece;
    }
    
    private function calculTotalOrderPrice(float $number, float $totalprice) : float
    {
        $TotalOrderPrice = $totalprice + $number;
        return $TotalOrderPrice;
    }
}
?>