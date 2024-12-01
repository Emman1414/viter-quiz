import React from "react";
import { StoreProvider } from "./components/store/storeContext";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Quiz from "./components/pages/frontend/Quiz";
import Question from "./components/pages/backend/question/Question";

const App = () => {
  return (
    <StoreProvider>
      <Router>
        <Routes>
          <Route index element={<Quiz />} />
          <Route path="/admin/question" element={<Question />} />
        </Routes>
      </Router>
    </StoreProvider>
  );
};

export default App;
