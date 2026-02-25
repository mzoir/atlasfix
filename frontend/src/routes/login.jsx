import { useRef, useState, useEffect } from "react";
import { Link, useNavigate, Navigate } from "react-router-dom";
import api from "./api.js";
import "./Styles/logst.css";

export default function Login() {
  const emailRef = useRef(null);
  const passwordRef = useRef(null);
  const navigate = useNavigate();

  const [message, setMessage] = useState("");
  const [isLogged, setIsLogged] = useState(false);

  // ✅ Check if already logged
  useEffect(() => {
    const token = localStorage.getItem("token");
    if (token) setIsLogged(true);
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();

    const email = emailRef.current.value;
    const password = passwordRef.current.value;

    try {
      const res = await api.post("/login", { email, password });

      setMessage(res.data.message || "Login successful");

      localStorage.setItem("user", JSON.stringify(res.data.user));
      localStorage.setItem("token", res.data.token);

      // redirect after login
      navigate("/admin");

    } catch (error) {
      setMessage(
        error.response?.data?.message || "Login failed"
      );
    }
  };

  // ✅ Redirect if already logged
  if (isLogged) {
    return <Navigate to="/admin" replace />;
  }

  return (
    <div className="login-page">
      <form className="login-form" onSubmit={handleSubmit}>
        <h2>Login</h2>

        <input
          className="email1"
          type="email"
          placeholder="Email"
          ref={emailRef}
          required
        />

        <input
          className="email2"
          type="password"
          placeholder="Password"
          ref={passwordRef}
          required
        />

        <button className="btn1" type="submit">
          Login
        </button>

        {message && (
          <p
            className="message"
            style={{
              color: message.includes("successful")
                ? "green"
                : "red",
            }}
          >
            {message}
          </p>
        )}

        <hr />

        <p className="link-text">
          <Link to="/forgot-password">
            Forget Password?
          </Link>
        </p>
      </form>
    </div>
  );
}
