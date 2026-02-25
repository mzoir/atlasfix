import { Link, Outlet } from "react-router-dom";
import "./App.css";
import photo from "./assets/images2.jfif";
                     

function App() {

  
  return (
    <>
      <nav className="navbar">
      

        <div className="right-nav">
          <Link className="text-a" to="/">Home</Link>
          <Link className="text-a" to="/Admin">User</Link>
          <Link className="text-a" to="/login">login</Link>
          <Link className="text-a" to="/register">register</Link>
          
          
        </div>

        
      </nav>

      {/* 👇 ICI LES PAGES ENFANTS */}
        <main className="page">
       <Outlet/>
      </main>
   
     
    </>
  );
}

export default App;
