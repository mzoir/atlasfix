import { createBrowserRouter } from "react-router-dom";
import App from "../App";

import Home from "./home";
import Admin from "./admi";      
import Login from "./login";  
import Register from "./register";
import Logout from "./logout"; 

const router = createBrowserRouter([
  {
    path: "/",
    element: <App />,   // layout parent
    children: [
      { index: true, element: <Home /> },
      { path: "admin", element: <Admin /> },
      { path: "login", element: <Login /> }, // ✅
      { path: "logout", element: <Logout /> },
      {path:"register",element:<Register />},
    ],
  },
]);

export default router;
