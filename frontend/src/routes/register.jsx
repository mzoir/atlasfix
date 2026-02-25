import { useState, useEffect } from "react";
import { Link, Navigate } from "react-router-dom";
import axios from "axios";
import "./Styles/logst.css";

function Register() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState("");
  const [date_of_birth, setDateOfBirth] = useState("");
  const [phone, setPhone] = useState("");
  const [name, setName] = useState("");

  // ✅ Auth check
  const [isLogged, setIsLogged] = useState(false);

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (token) setIsLogged(true);
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setMessage("");

    try {
      const res = await axios.post(
        "http://127.0.0.1:8000/api/register",
        {
          name,
          email,
          password,
          date_of_birth,
          phone,
        }
      );

      // ✅ Success message
      setMessage(res.data.message || "Registration successful");

      // ✅ Reset fields
      setName("");
      setEmail("");
      setPassword("");
      setDateOfBirth("");
      setPhone("");

    } catch (error) {
      setMessage(
        error.response?.data?.message || "Registration failed"
      );
    }
  };

  // ✅ REDIRECT if already logged
  if (isLogged) {
    return <Navigate to="/" replace />;
  }

  return (
    <div className="login-page">
      <form className="login-form" onSubmit={handleSubmit}>
        <h2>Register</h2>

        <input
          className="email1"
          type="text"
          placeholder="Name"
          value={name}
          onChange={(e) => setName(e.target.value)}
          required
        />

        <input
          className="email1"
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />

        <input
          className="email2"
          type="date"
          value={date_of_birth}
          onChange={(e) => setDateOfBirth(e.target.value)}
          required
        />

        <input
          className="email2"
          type="tel"
          placeholder="Phone Number"
          value={phone}
          onChange={(e) => setPhone(e.target.value)}
          required
        />

        <input
          className="email2"
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />

        <button className="btn1" type="submit">
          Register
        </button>

        {/* Message */}
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
          Already have an account? <Link to="/login">Login</Link>
        </p>
      </form>
    </div>
  );
}

export default Register;
