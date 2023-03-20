<?php
class ProductManager extends AbstractManager {

    public function getProductById(int $id) : array
    {
       
        $query = $this->db->prepare("SELECT * FROM product WHERE id=:id");
        $parameter = ['id' =>$id];
        $query->execute($parameter);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $return = [];
        $ProductToReturn = new Product(intval($product["id"]),$product["name"], $product["description"],
                $product["slug"], floatval($product["price"]), intval($product["category_id"]));
        $ProductToReturn->setId($product["id"]);
        $return[]=$ProductToReturn;
        return $return;
    }
    public function getProductById1(int $id) : Product
    {
       
        $query = $this->db->prepare("SELECT * FROM product WHERE id=:id");
        $parameter = ['id' =>$id];
        $query->execute($parameter);
        $product = $query->fetch(PDO::FETCH_ASSOC);
       
        $ProductToReturn = new Product(intval($product["id"]),$product["name"], $product["description"],
                $product["slug"], floatval($product["price"]), intval($product["category_id"]));
        $ProductToReturn->setId($product["id"]);
        
        return $ProductToReturn;
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
        
        return $this->db->lastInsertId();
    }
    public function getProductByName(string $name) : Product
    {
        $query = $this->db->prepare("SELECT * FROM product WHERE name=:name");
        $parameter = ['name' =>$name];
        $query->execute($parameter);
        $products = $query->fetch(PDO::FETCH_ASSOC);
        $ProductToReturn = new Product($products["name"],$products["description"],$products["price"],$products["category_id"]);
        $ProductToReturn->setId($products["id"]);
        
        return $ProductToReturn ;
    }
    public function getProductBySlug(string $slug) : Product
    {
        $query = $this->db->prepare("SELECT * FROM product WHERE slug=:slug");
        $parameter = ['slug' =>$slug];
        $query->execute($parameter);
        $products = $query->fetch(PDO::FETCH_ASSOC);
        $ProductToReturn = new Product(intval($products["id"]),$products["name"],$products["description"],$products["slug"],floatval($products["price"]),intval($products["category_id"]));
        $ProductToReturn->setId(intval($products["id"]));
        $ProductToReturn->setSlug($products["slug"]);
        
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
                $product["slug"], intval($product["price"]), intval($product["category_id"]));
                $newProduct->setId($product["id"]);
                $newProduct->setSlug($product["slug"]);
                $return[]=$newProduct;
            }
            return $return;
        }
    public function editProduct(Product $product) : void
    {
    $query = $this->db->prepare("UPDATE product SET name=:name, description=:description, price=:price, category_id=:category_id WHERE id=:id");
    $parameters = [
        'id'=>$product->getId(),
        'name'=>$product->getName(),
        'description'=>$product->getDescription(),
        'price'=>$product->getPrice(),
        'category_id'=>$product->getCategoryId()
    ];
    $query->execute($parameters);
    }
    
    public function addIngredientOnProduct(int $ingredientId,int $productId)
        {
            $query = $this->db->prepare('INSERT INTO product_has_ingredient VALUES (:ProductId , :ingredientId )');
            $parameters = [
                'ingredientId' => $ingredientId,
                'ProductId' => $productId
            ];
    
            $query->execute($parameters);
        }
    public function addAllergenOnProduct(int $allergenId,int $productId)
        {
            $query = $this->db->prepare('INSERT INTO product_has_allergen VALUES (:ProductId , :allergenId )');
            $parameters = [
                'allergenId' => $allergenId,
                'ProductId' => $productId
            ];
    
            $query->execute($parameters);
        }
  
    public function deleteProduct(Product $product)
    {
        
        $query = $this->db->prepare("DELETE FROM product WHERE id=:id");
        $parameters = [
            'id'=>$product->getId()
        ];
        $query->execute($parameters);
    }
    
    public function deleteAllergenOnProduct(int $productId)
        {
            $query = $this->db->prepare('DELETE FROM product_has_allergen WHERE product_id=:product_id');
            $parameters = [
                'product_id' => $productId
            ];
    
            $query->execute($parameters);
        }
    public function deleteIngredientOnProduct(int $productId)
        {
            $query = $this->db->prepare('DELETE FROM product_has_ingredient WHERE product_id=:product_id');
            $parameters = [
                'product_id' => $productId
            ];
    
            $query->execute($parameters);
        }
    
    
}
?>