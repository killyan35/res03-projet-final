<?php
require 'controllers/AbstractController.php';
require 'controllers/CategoryController.php';
require 'controllers/AdminController.php';
require 'controllers/EventController.php';
require 'controllers/ProductController.php';
require 'controllers/UserController.php';
require 'controllers/IngredientController.php';

require 'managers/AbstractManager.php';
require 'managers/AdminManager.php';
require 'managers/CategoryManager.php';
require 'managers/EventManager.php';
require 'managers/IngredientManager.php';
require 'managers/OrderManager.php';
require 'managers/ProductManager.php';
require 'managers/UserManager.php';

require 'models/Address.php';
require 'models/Category.php';
require 'models/Ingredient.php';
require 'models/Media.php';
require 'models/Order.php';
require 'models/Product.php';
require 'models/User.php';

require 'services/Router.php';