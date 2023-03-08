<?php
class Order {
    // private attribute
    private ?int $id;
    private int $userId;
    private int $billingId;
    private int $deliveryId;

    // public constructor
    public function __construct(int $userId, int $billingId, int $deliveryId)
    {
        $this->id = null;
        $this->userId = $userId;
        $this->billingId = $billingId;
        $this->deliveryId = $deliveryId;
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
    public function getBillingId() : int
    {
        return $this->billingId;
    }
    public function getDeliveryId() : int
    {
        return $this->deliveryId;
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
    public function setBillingId(int $billingId) : void
    {
        $this->billingId = $billingId;
    }
    public function setDeliveryId(int $deliveryId) : void
    {
        $this->deliveryId = $deliveryId;
    }
}
?>