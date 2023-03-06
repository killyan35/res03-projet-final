## Models

### User
* id (int)
* name (string)
* email (string)
* password (string)
* role (string)
* shippingAddress (Address)
* billingAddress (Adress)

### Adress
* id (int)
* street (string)
* city (string)
* number (int)
* zipcode (int)

### Category
* id (int)
* name (string)
* description (string)
* slug (string)

### Product
* id (int)
* name (string)
* description (string)
* ingredients (Ingredient)
* categoryId (int)
* size (int)
* price (int)
* slug (string)

### Ingredient
* id (int)
* name (string)
* description (string)

### Order
* id (int)
* userId (int)
* billingId (int)
* deliveryId (int)