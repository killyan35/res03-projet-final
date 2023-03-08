<?php
class Adress {
    // private attribute
    private ?int $id;
    private string $street;
    private string $city;
    private int $number;
    private int $zipcode;
    // public constructor
    public function __construct(string $street, string $city, int $number, int $zipcode)
    {
        $this->id = null;
        $this->street = $street;
        $this->city = $city;
        $this->number = $number;
        $this->zipcode = $zipcode;
    }

    // public getter
    public function getId() : int
    {
        return $this->id;
    }
    public function getStreet() : string
    {
        return $this->street;
    }
    public function getCity() : string
    {
        return $this->city;
    }
    public function getNumber() : int
    {
        return $this->number;
    }
    public function getZipcode() : int
    {
        return $this->zipcode;
    }
    
    // public setter
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    public function setStreet(string $street) : void
    {
        $this->street = $street;
    }
    public function setCity(string $city) : void
    {
        $this->city = $city;
    }
    public function setNumber(int $number) : void
    {
        $this->number = $number;
    }
    public function setZipcode(int $zipcode) : void
    {
        $this->zipcode = $zipcode;
    }
}
?>