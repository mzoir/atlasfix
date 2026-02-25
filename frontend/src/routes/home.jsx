import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import api from "./api.js";

import "./Styles/EmptyState.css";
import Admin from "./admi.jsx";

export default function Home() {
  const [authState, setAuthState] = useState(null);
  const [user, setUser] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem("token");

    if (!token) {
      setAuthState(false);
      return;
    }

    api
      .get("/user") // ✅ Laravel /api/user
      .then((res) => {
        setUser(res.data);
        setAuthState(true);
      })
      .catch(() => {
        localStorage.removeItem("token");
        setAuthState(false);
      });
  }, []);

  const logout = async () => {
    try {
      await api.post("/logout");
    } catch (_) { }

    localStorage.removeItem("token");
    window.location.href = "/login";
  };

  if (authState === null)
    return <p style={{ padding: 20 }}>Checking authentication...</p>;

  // ❌ Not logged
  if (authState === false) {
    return (
      <div style={center}>
        <div style={loginBox}>
          <h2>Please log in</h2>
          <Link to="/login" style={loginBtn}>
            Go to Login
          </Link>
        </div>
      </div>
    );
  }

  // ✅ Logged
  return (
    <div
      style={{
        minHeight: "100vh",
        padding: 30,
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
      }}
    >
      <div style={{ width: "100%", maxWidth: 920 }}>

        {/* ================= PROFILE CARD ================= */}
        <div
          style={{
            background: "rgba(255,255,255,0.08)",
            padding: 24,
            borderRadius: 12,
            marginBottom: 20,
            color: "#fff",
          }}
        >
          {/* Top row */}
          <div
            style={{
              display: "flex",
              alignItems: "center",
              justifyContent: "space-between",
              flexWrap: "wrap",
              gap: 16,
            }}
          >
            {/* Avatar + Info */}
            <div style={{ display: "flex", gap: 16, alignItems: "center" }}>
              <div style={avatar}>
                {user?.name?.charAt(0).toUpperCase()}
              </div>

              <div>
                <div style={{ fontSize: 20, fontWeight: "bold" }}>
                  {user?.name}
                </div>
                <div style={{ opacity: 0.8 }}>{user?.email}</div>
              </div>
            </div>

            {/* Logout */}
            <button onClick={logout} style={logoutBtn}>
              Logout
            </button>
          </div>

          {/* Attributes */}
          <div style={grid}>
            <Attr label="ID" value={user?.id} />
            <Attr label="Name" value={user?.name} />
            <Attr label="Email" value={user?.email} />
            <Attr label="Created At" value={user?.created_at} />
          </div>

          {/* Buttons */}
          <div style={btnRow}>

            <Link className="text-a" to="/Admin">
              <button className="admin-btn">User</button>
            </Link>

          </div>
        </div>

        {/* ================= EMPTY STATE (unchanged) ================= */}

      </div>
    </div>
  );
}

/* ================= Attribute Component ================= */

function Attr({ label, value }) {
  return (
    <div
      style={{
        background: "rgba(255,255,255,0.08)",
        padding: 12,
        borderRadius: 8,
      }}
    >
      <div style={{ opacity: 0.7, fontSize: 13 }}>{label}</div>
      <div style={{ fontWeight: "bold" }}>{value ?? "-"}</div>
    </div>
  );
}

/* ================= Styles ================= */

const center = {
  minHeight: "100vh",
  display: "flex",
  alignItems: "center",
  justifyContent: "center",
};

const loginBox = {
  padding: 24,
  borderRadius: 8,
  textAlign: "center",
  background: "#f1f5f9",
};

const loginBtn = {
  display: "inline-block",
  marginTop: 12,
  padding: "8px 16px",
  background: "#667eea",
  color: "#fff",
  borderRadius: 6,
  textDecoration: "none",
};

const avatar = {
  width: 70,
  height: 70,
  borderRadius: "50%",
  background: "#667eea",
  display: "flex",
  alignItems: "center",
  justifyContent: "center",
  fontSize: 28,
  fontWeight: "bold",
};

const logoutBtn = {
  padding: "8px 18px",
  background: "#ff4d4f",
  border: "none",
  color: "#fff",
  borderRadius: 6,
  cursor: "pointer",
};

const grid = {
  marginTop: 20,
  display: "grid",
  gridTemplateColumns: "repeat(auto-fit,minmax(200px,1fr))",
  gap: 12,
};

const btnRow = {
  marginTop: 24,
  display: "flex",
  gap: 12,
  flexWrap: "wrap",
};
