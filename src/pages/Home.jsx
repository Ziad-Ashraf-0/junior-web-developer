import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import axios from "axios";
import "./home.css";

function Home() {
  const [products, setProducts] = useState([]);
  const [selectedProducts, setSelectedProducts] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        //remote url "http://ziad42.000webhostapp.com/scandiweb/endpoint/index.php/?url=endpoint"
        //local url "http://localhost/scandiweb-endpoint/?url=endpoint"
        const response = await axios.get(
          "http://ziad42.000webhostapp.com/scandiweb/endpoint/index.php/?url=endpoint"
        );
        setProducts(response.data);
        console.log(response.data);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };
    fetchData();
  }, []);

  // Function to handle checkbox selection
  const handleCheckboxChange = (productId) => {
    setSelectedProducts((prevSelectedProducts) => {
      if (prevSelectedProducts.includes(productId)) {
        return prevSelectedProducts.filter((id) => id !== productId);
      } else {
        return [...prevSelectedProducts, productId];
      }
    });
  };

  useEffect(() => {
    console.log(selectedProducts);
  }, [selectedProducts]);

  const handleMassDelete = async () => {
    try {
      const response = await axios.get(
        "http://ziad42.000webhostapp.com/scandiweb/endpoint/index.php/",
        {
          params: {
            url: "endpoint",
            ids: selectedProducts.join(","),
          },
          headers: {
            "Content-Type": "text/plain",
          },
        }
      );

      console.log(response);

      if (response.status === 200) {
        // Filter products based on selected product IDs
        const filteredProducts = products.filter(
          (product) => !selectedProducts.includes(product.sku)
        );
        // Update the state with filtered products
        setProducts(filteredProducts);
        setSelectedProducts([]);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  };

  return (
    <div className="container">
      <div className="header">
        <div>
          <h1>Product List</h1>
        </div>
        <div>
          <Link to="/add" className="btn">
            ADD
          </Link>
          <Link className="btn" onClick={handleMassDelete}>
            mass delete
          </Link>
        </div>
      </div>

      <div className="product-container">
        {products.map((product, index) => (
          <div key={index} className="item">
            <input
              type="checkbox"
              checked={selectedProducts.includes(product.sku)}
              onChange={() => handleCheckboxChange(product.sku)}
              className="delete-checkbox"
            />
            <div>{product.sku}</div>
            <div>{product.name}</div>
            <div>{product.price} $</div>
            {product.type === "DVD" && <div>Size: {product.size}</div>}
            {product.type === "Book" && <div>Weight: {product.weight}</div>}
            {product.type === "Furniture" && (
              <div>Dimensions: {product.dimension}</div>
            )}
          </div>
        ))}
      </div>

      <div className="footer"> Scandiweb Test assignment</div>
    </div>
  );
}

export default Home;
