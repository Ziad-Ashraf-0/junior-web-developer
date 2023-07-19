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
        //remote url "http://ziad42.000webhostapp.com/"
        //local url "http://localhost/demo/"
        const response = await axios.get(
          "https://ziad42.000webhostapp.com/scandiweb/endpoint/"
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

    console.log(selectedProducts);
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
          <Link className="btn">mass delete</Link>
        </div>
      </div>

      <div className="product-container">
        {products.map((product, index) => (
          <div key={index} className="item">
            <input
              type="checkbox"
              checked={selectedProducts.includes(product.id)}
              onChange={() => handleCheckboxChange(product.id)}
              className="delete-checkbox"
            />
            <div>{product.sku}</div>
            <div>{product.name}</div>
            <div>{product.price} $</div>
            {product.type === "DVD" && <div>Size: {product.size}</div>}
            {product.type === "Book" && <div>Weight: {product.weight}</div>}
            {product.type === "Furniture" && (
              <div>
                Dimensions: {product.height}x{product.length}x{product.width}
              </div>
            )}
          </div>
        ))}
      </div>

      <div className="footer"> Scandiweb Test assignment</div>
    </div>
  );
}

export default Home;
