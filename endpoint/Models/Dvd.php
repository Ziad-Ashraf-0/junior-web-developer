<?php

namespace Models;

use Database\Query;
use Models\Product;

class Dvd extends Product
{
    public function __construct($sku , $name , $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = 'DVD';
        $this->attrType = 'Size';
    }

    public function create($data)
    {
        if ( ! $this->ValideProductData() )
            return;
        if ( ! $this->valideAttrValue($data) )
            return;
        $this->setAttrValue($data);
        $query = new Query();
        $query->create($this->getData());
    }

    protected function setAttrValue($data) 
    {
        $this->attrValue = $data['size'] ;

    }

    protected function valideAttrValue($data)
    {
        if ( isset($data['size']) )
        {
            if ( is_numeric($data['size']) )
                return TRUE;
            echo 'Please, enter a numeric value for the size.';
            return FALSE;
        }  
        echo 'Please, enter the value corresponding to the product type.';
        return FALSE;
    }
}

?>