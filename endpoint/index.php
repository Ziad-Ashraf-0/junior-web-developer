<?php
require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';

use Controller\MyController;


if ($_GET['url'] === 'endpoint') 
{
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $controller = new MyController($requestMethod);
    $controller->req();
}




// //local db
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "scandiweb";

// //remote db
// // $servername = "localhost";
// // $username = "id19219278_ziad";
// // $password = "Cc1234567#";
// // $dbname = "id19219278_ziad";

// class Product
// {
//     public $sku;
//     public $name;
//     public $price;

//     public function __construct($sku, $name, $price)
//     {
//         $this->sku = $sku;
//         $this->name = $name;
//         $this->price = $price;
//     }

//     public function getSKU()
//     {
//         return $this->sku;
//     }

//     public function getName()
//     {
//         return $this->name;
//     }

//     public function getPrice()
//     {
//         return $this->price;
//     }
// }

// class DVD extends Product
// {
//     public $size;
//     public $type = "DVD";
//     public function __construct($sku, $name, $price, $size)
//     {
//         parent::__construct($sku, $name, $price);
//         $this->size = $size;
//     }

//     public function getSize()
//     {
//         return $this->size;
//     }
// }

// class Book extends Product
// {
//     public $weight;
//     public $type = "Book";

//     public function __construct($sku, $name, $price, $weight)
//     {
//         parent::__construct($sku, $name, $price);
//         $this->weight = $weight;
//     }

//     public function getWeight()
//     {
//         return $this->weight;
//     }
// }

// class Furniture extends Product
// {
//     public $length;
// 	public $height;
// 	public $width;
// 	public $type = "Furniture";

//     public function __construct($sku, $name, $price, $length, $height,$width)
//     {
//         parent::__construct($sku, $name, $price, $length, $height,$width);
//         $this->length = $length;
// 		$this->height = $height;
// 		$this->width = $width;
//     }

//     public function getLength()
//     {
//         return $this->length;
//     }
// 	 public function getHeight()
//     {
//         return $this->height;
//     }
// 	 public function getWidth()
//     {
//         return $this->width;
//     }
// }

// class ProductManager
// {
//     private $conn;

//     public function __construct($conn)
//     {
//         $this->conn = $conn;
//     }

//     public function getAllProducts()
//     {	
		
//         $query = "SELECT * FROM products";
//         $stmt = $this->conn->prepare($query);
//         $stmt->execute();
//         $products = [];

		

//         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//             $sku = $row['sku'];
//             $name = $row['name'];
//             $price = $row['price'];
//             $type = $row['type'];

//             switch ($type) {
//                 case 'DVD':
//                     $size = $row['size'];
//                     $product = new DVD($sku, $name, $price, $size);
//                     break;

//                 case 'Book':
//                     $weight = $row['weight'];
//                     $product = new Book($sku, $name, $price, $weight);
//                     break;

//                 case 'Furniture':
					
//                     $length = $row['length'];
// 					$height = $row['height'];
// 					$width = $row['width'];
//                     $product = new Furniture($sku, $name, $price, $length, $height,$width);
//                     break;

//                 default:
                    
//                     break;
//             }
// 			$products[] = $product;

// 		}


// 		return $products;
          
//     }     


//     public function addProduct($product)
//     {
//         $sku = $product->getSKU();
//         $name = $product->getName();
//         $price = $product->getPrice();
//         $type = '';

//         if ($product instanceof DVD) {
//             $type = 'DVD';
//             $size = $product->getSize();
//             $query = "INSERT INTO products (sku, name, price, type, size) VALUES (?, ?, ?, ?, ?)";
//             $params = [$sku, $name, $price, $type, $size];
//         } elseif ($product instanceof Book) {
//             $type = 'Book';
//             $weight = $product->getWeight();
//             $query = "INSERT INTO products (sku, name, price, type, weight) VALUES (?, ?, ?, ?, ?)";
//             $params = [$sku, $name, $price, $type, $weight];
//         } elseif ($product instanceof Furniture) {
//             $type = 'Furniture';
//             $length = $product->getLength();
//             $height = $product->getHeight();
//             $width = $product->getWidth();
//             $query = "INSERT INTO products (sku, name, price, type, length, height,width) VALUES (?, ?, ?, ?, ?, ?, ?)";
//             $params = [$sku, $name, $price, $type, $length, $height,$width];
//         }

//         $stmt = $this->conn->prepare($query);
//         $success = $stmt->execute($params);
//         return $success;
//     }

//     public function deleteAllProducts()
//     {
//         $query = "DELETE FROM products";
//         $stmt = $this->conn->prepare($query);
//         $stmt->execute();
//     }
// }






// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $productManager = new ProductManager($conn);

//     // Handle API endpoints
//     $requestMethod = $_SERVER['REQUEST_METHOD'];
//     $uri = $_SERVER['REQUEST_URI'];

//     // // Parse the URI to determine the endpoint and any additional parameters
//     // $uri = parse_url($uri, PHP_URL_PATH);
//     // $uri = explode('/', $uri);
//     // $endpoint = $uri[1];

	

//     // Handle the endpoints
   
//         switch ($requestMethod) {
//             case 'GET':	
//                 // Get all products
//                 $products = $productManager->getAllProducts();
//                 header('Content-Type: application/json');
//                 echo json_encode($products);
//                 break;
//             case 'POST':
//                 // Add a new product
//                 $inputData = file_get_contents('php://input');
//                 echo $inputData; // Log the received data to the error log or a file
//                 $data = json_decode($inputData, true);

//                 if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
//                  // An error occurred during JSON decoding
//                  echo 'Error decoding JSON: ' . json_last_error_msg();
//                 } else {
//                 }

//                 $sku = $data['sku'];
//                 $name = $data['name'];
//                 $price = $data['price'];
//                 $type = $data['type'];

//                 switch ($type) {
//                     case 'DVD':
//                         $size = $data['size'];
//                         $product = new DVD($sku, $name, $price, $size);
//                         break;

//                     case 'Book':
//                         $weight = $data['weight'];
//                         $product = new Book($sku, $name, $price, $weight);
//                         break;

//                     case 'Furniture':
//                         $length = $data['length'];
//                         $height = $data['height'];
//                         $width = $data['width'];
//                         $product = new Furniture($sku, $name, $price, $length, $height,$width);
//                         break;

//                     default:
//                         // Handle unrecognized product types if needed
//                         break;
//                 }

//                  $success = $productManager->addProduct($product);

//                 if ($success) {
//                     $response = array('message' => 'Product added successfully');
//                 } else {
//                     $response = array('message' => 'Failed to add product');
//                 }

//                 header('Content-Type: application/json');
//                 echo json_encode($response);
//                 break;

//             case 'DELETE':
//                 // Delete all products
//                 $productManager->deleteAllProducts();
//                 break;

//             default:
//                 // Handle unrecognized request methods if needed
//                 break;
//         }
    

// } catch (PDOException $e) {
//     echo 'Connection failed: ' . $e->getMessage();
// }

?>
