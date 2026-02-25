import { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import api from "./api.js";

// Export a path constant so existing code can use it as href
export const logout = "/logout";

export default function Logout() {
  const navigate = useNavigate();

  useEffect(() => {
    async function doLogout() {
      try {
        // Call API logout (revokes token server-side)
        await api.post("/logout");
      } catch (e) {
        // ignore errors (token may be invalid or already revoked)
      }

      // Clear client-side storage
      localStorage.removeItem("token");
      localStorage.removeItem("user");

      // Redirect to login
      navigate("/login");
    }

    doLogout();
  }, [navigate]);

}
