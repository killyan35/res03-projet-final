<?php
class ProductManager extends AbstractManager {

    public function getProductById(int $id) : Product
    {
       
        $query = $this->db->prepare("SELECT * FROM product WHERE id=:id");
        $parameters = [
            'id'=>$id
        ];
        $query->execute($parameters);
        $products = $query->fetch(PDO::FETCH_ASSOC);
        $return = new Product($products["name"],$products["description"],$products["price"],$products["categoryId"]);
        $return->setId($products["id"]);
        
        return $return;
    }
    public function insertProduct(Product $product) : Product
    {
        $query = $this->db->prepare('INSERT INTO product VALUES (null, :value1, :value2, :value3, :value4, :value5)');
        $parameters = [
        'value1' => $salon->getName(),
        'value2' => $salon->getSlug(),
        'value3' => $salon->getDescription(),
        'value4' => $salon->getPrice(),
        'value5' => $salon->getCategoryId()
        ];
        $query->execute($parameters);
        $query = $this->db->prepare("SELECT * FROM product WHERE name=:value");
        $parameter = ['value' => $product->getName()];
        $query->execute($parameter);
        $products = $query->fetch(PDO::FETCH_ASSOC);
        $ProductToReturn = new Product($products["name"],$products["description"],$products["price"],$products["categoryId"]);
        $ProductToReturn->setId($products["id"]);
        
        return $ProductToReturn ;
    }
    public function getProductByName(string $name) : Product
    {
        $query = $this->db->prepare("SELECT * FROM product WHERE name=:name");
        $parameter = ['name' =>$name];
        $query->execute($parameter);
        $products = $query->fetch(PDO::FETCH_ASSOC);
        $ProductToReturn = new Product($products["name"],$products["description"],$products["price"],$products["categoryId"]);
        $ProductToReturn->setId($products["id"]);
        
        return $ProductToReturn ;
    }
    public function findAllProduct() : array
        {
            $query = $this->db->prepare("SELECT * FROM product");
            $query->execute([]);
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($products as $product)
            {
                $newproduct= new Product($products["name"],$products["description"],$products["price"],$products["categoryId"]);
                $newproduct->setId($product["id"]);
                $return[]=$newproduct;
                
            }
            return $return;
        }
    public function editProduct(Product $product) : void
    {
    $query = $this->db->prepare("UPDATE user SET name=:name, description=:description, price=:price, category_id=:category_id WHERE product.id=:id");
    $parameters = [
        'id'=>$product->getId(),
        'name'=>$product->getName(),
        'description'=>$product->getDescription(),
        'price'=>$product->getPrice(),
        'category_id'=>$product->getCategory_id()
    ];
    $query->execute($parameters);
    }
}
?>