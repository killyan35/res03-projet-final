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
    public function insertProduct(Product $product)
    {
        $query = $this->db->prepare('INSERT INTO product VALUES (null, :value1, :value2, :value3, :value4, :value5)');
        $parameters = [
        'value1' => $product->getName(),
        'value2' => $product->getDescription(),
        'value3' => $product->getSlug(),
        'value4' => $product->getPrice(),
        'value5' => $product->getCategoryId()
        ];
        $query->execute($parameters);
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
    public function findAllProducts() : array
        {
            $query = $this->db->prepare("SELECT * FROM product");
            $query->execute([]);
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($products as $product)
            {
                $newProduct = new Product(intval($product["id"]),$product["name"], $product["description"],
                $product["slug"], floatval($product["price"]), intval($product["category_id"]));
                $newProduct->setId($product["id"]);
                $newProduct->setSlug($product["slug"]);
                $return[]=$newProduct;
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