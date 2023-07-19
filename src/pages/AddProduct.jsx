import React, { useState, useRef } from "react";
import { Link } from "react-router-dom";
import axios from "axios";

import "./home.css";

const AddProduct = () => {
  const [type, setType] = useState("DVD"); // Default type is "dvd"
  const hiddenSubmitButtonRef = useRef(null);

  const handleTypeChange = (event) => {
    setType(event.target.value);
  };

  const renderTypeFields = () => {
    switch (type) {
      case "DVD":
        return (
          <div className="field">
            <label htmlFor="size">Size (MB)</label>
            <input type="text" id="size" name="size" />
          </div>
        );
      case "Furniture":
        return (
          <div>
            <div className="field">
              <label htmlFor="height">Height</label>
              <input type="text" id="height" name="height" />
            </div>
            <div className="field">
              <label htmlFor="width">Width</label>
              <input type="text" id="width" name="width" />
            </div>
            <div className="field">
              <label htmlFor="length">Length</label>
              <input type="text" id="length" name="length" />
            </div>
          </div>
        );
      case "Book":
        return (
          <div className="field">
            <label htmlFor="weight">Weight</label>
            <input type="text" id="weight" name="weight" />
          </div>
        );
      default:
        return null;
    }
  };

  const handleSubmit = (event) => {
    event.preventDefault();

    const formData = {
      sku: event.target.elements.sku.value,
      name: event.target.elements.name.value,
      price: event.target.elements.price.value,
      type: type,
    };

    switch (type) {
      case "DVD":
        formData.size = event.target.elements.size.value;
        break;
      case "Furniture":
        formData.height = event.target.elements.height.value;
        formData.width = event.target.elements.width.value;
        formData.length = event.target.elements[6].value; //weird error !! if i used same as previous
        break;
      case "Book":
        formData.weight = event.target.elements.weight.value;
        break;
      default:
        break;
    }

    console.log(formData);

    //remote url "http://ziad42.000webhostapp.com/"
    //local url "http://localhost/demo/"

    axios
      .post("https://ziad42.000webhostapp.com/scandiweb/endpoint/", formData)
      .then((response) => {
        console.log("Product added successfully:", response.data);
      })
      .catch((error) => {
        console.error("Error adding product:", error);
      });
  };

  const handleSaveClick = () => {
    hiddenSubmitButtonRef.current.click();
  };

  return (
    <div className="container">
      <div className="header">
        <div>
          <h1>Product Add</h1>
        </div>
        <div>
          <Link onClick={handleSaveClick} className="btn">
            Save
          </Link>
          <Link to="/" className="btn">
            Cancel
          </Link>
        </div>
      </div>

      <form id="product_form" onSubmit={handleSubmit}>
        <div className="field">
          <label htmlFor="sku">SKU</label>
          <input type="text" id="sku" name="sku" />
        </div>
        <div className="field">
          <label htmlFor="name">Name</label>
          <input type="text" id="name" name="name" />
        </div>
        <div className="field">
          <label htmlFor="price">Price ($)</label>
          <input type="number" id="price" name="price" />
        </div>
        <div className="field">
          <label htmlFor="type">Type:</label>
          <select
            id="type"
            name="type"
            value={type}
            onChange={handleTypeChange}
          >
            <option value="DVD">DVD</option>
            <option value="Furniture">Furniture</option>
            <option value="Book">Book</option>
          </select>
        </div>
        <div id="type_fields">{renderTypeFields()}</div>
        <button
          type="submit"
          ref={hiddenSubmitButtonRef}
          style={{ display: "none" }}
        />
      </form>

      <div className="footer">Scandiweb Test assignment</div>
    </div>
  );
};

export default AddProduct;
