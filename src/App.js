import { BrowserRouter, Routes, Route } from "react-router-dom";

import AddProduct from "./pages/AddProduct";
import Home from "./pages/Home";

function App() {
  return (
    <div>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="add" element={<AddProduct />} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;
