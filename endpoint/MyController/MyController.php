<?php 

namespace Controller;

use Models\Product;

class MyController
{
    private $requestType;

    public function __construct($requestType)
    {
        $this->requestType = $requestType;
    }

    public function req()
    {
        switch ($this->requestType) {
            case 'GET':
                $ids = $this->getDataFromUrl('ids');
                if ($ids !== null) {
                    // Delete products with specified IDs
                    Product::delete($ids);
                } else {
                    // Get all products
                    Product::selectAll();
                }
                break;
            case 'POST':
                $this->create();
                break;
            default:
                echo '404';
                break;
        }
    }

    private function create()
    {

        $productType = ucfirst(strtolower( filter_var($this->getData('type') , FILTER_SANITIZE_FULL_SPECIAL_CHARS) ));
        $className = 'Models\\' . $productType; 
        $productSku = filter_var($this->getData('sku') , FILTER_SANITIZE_FULL_SPECIAL_CHARS);   
        $productName = filter_var($this->getData('name') , FILTER_SANITIZE_FULL_SPECIAL_CHARS);   
        $productPrice = filter_var($this->getData('price') , FILTER_SANITIZE_FULL_SPECIAL_CHARS);   
        if (Product::skuNotAvailable($productSku) )
        {
            echo 'SKU not available';
            return;
        }
        $product = new $className($productSku , $productName , $productPrice);
        $product->create($this->getData());
 
    }


    private function getData($value = '')
    {
        $json = json_decode(file_get_contents('php://input'), true);  
        if ($value === '')
            return $json;
        if (!$json[$value]) 
            return NULL;
        return $json[$value];
    }

    private function getDataFromUrl($param)
    {
        // Assuming the IDs are passed as a comma-separated list in the URL, e.g., ?ids=1,2,3
        $idsString = filter_input(INPUT_GET, $param, FILTER_SANITIZE_STRING);
    
        if ($idsString !== false && $idsString !== null) {
              // Convert the comma-separated string to an array of IDs
             $idsArray = explode(',', $idsString);
            // Return the array of IDs
            return $idsArray;
        }

        return null;
    }


}

?>