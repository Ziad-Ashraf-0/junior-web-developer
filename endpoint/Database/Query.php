<?php

namespace Database;

use Database\Connection;

class Query extends Connection
{
    public function all()
    {
        $sql = "SELECT * FROM products";
        $query = $this->getDb()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function productExist($sku)
    {
        $sql = 'SELECT * FROM `products` WHERE sku = ?';
        $query = $this->getDb()->prepare($sql);
        $query->execute([$sku]);
        return empty($query->fetch()) ? FALSE : TRUE;
    }

    public function create($data)
    {
        $nullValue = null;
        $sql = 'INSERT INTO `products` (sku, name, price, type, size, dimension, weight) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $query = $this->getDb()->prepare($sql);


        //The product type determines which attribute to insert
        if ($data['attribute'][0] === 'Size') {
            $query->bindParam(5, $data['attribute'][1]);  // Size for DVDs
            $query->bindParam(6, $nullValue);   // Set Dimension to NULL
            $query->bindParam(7, $nullValue);   // Set Weight to NULL
        } elseif ($data['attribute'][0] === 'Weight') {
            $query->bindParam(5, $nullValue);   // Set Size to NULL
            $query->bindParam(6, $nullValue);   // Set Dimension to NULL
            $query->bindParam(7, $data['attribute'][1]);  // Weight for Furniture       
        } elseif ($data['attribute'][0] === 'Dimension') {
            $query->bindParam(5, $nullValue);   // Set Size to NULL
            $query->bindParam(6, $data['attribute'][1]);  // Dimension for Books
            $query->bindParam(7, $nullValue);   // Set Weight to NULL


        }

        // Bind other parameters
        $query->bindParam(1, $data['product'][0]);
        $query->bindParam(2, $data['product'][1]);
        $query->bindParam(3, $data['product'][2]);
        $query->bindParam(4, $data['product'][3]);

        // Print or log the parameters
        //$query->debugDumpParams();
        if ( !$query->execute())
            return 'Error';
    }

    public function delete($id)
{
    if (empty($id)) {
        echo 'Invalid SKU provided for deletion.';
        return;
    }

    // Trim SKU to remove leading and trailing spaces
    $id = trim($id);

    // Convert SKU to uppercase
    $id = strtoupper($id);

    $sql = 'DELETE FROM `products` WHERE sku = ?';
    $query = $this->getDb()->prepare($sql);

    try {
        $query->execute([$id]);
        echo 'Product with SKU ' . $id . ' deleted successfully.';
    } catch (PDOException $e) {
        echo 'Error deleting product: ' . $e->getMessage();
    }
}  
    
}

?>