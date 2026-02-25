import { useEffect, useState, useRef } from "react";
import api from "./api.js";
import { logout } from "./logout.js";

export default function Produit() {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  const [editingId, setEditingId] = useState(null);
  const [editName, setEditName] = useState("");
  const [editStock, setEditStock] = useState("");

  // New product form state
  const [showNewForm, setShowNewForm] = useState(false);
  const newNameRef = useRef(null);
  const [newName, setNewName] = useState("");
  const [newDescription, setNewDescription] = useState("");
  const [newPrice, setNewPrice] = useState("");
  const [newStock, setNewStock] = useState("");
 
  async function fetchProducts() {
    try {
      setLoading(true);
      setError("");

      const res = await api.get("me/products");
      setProducts(res.data || []);
    } catch (e) {
      setError(e.response?.data?.message || e.message || "Erreur lors du chargement");
    } finally {
      setLoading(false);
    }
  }

  useEffect(() => {
    fetchProducts();
  }, []);

  function startEdit(p) {
    setEditingId(p.id);
    setEditName(p.name || "");
    setEditStock(p.stock || "");
  }

  function cancelEdit() {
    setEditingId(null);
    setEditName("");
    setEditStock("");
  }

  async function saveEdit(id) {
    try {
      const res = await api.put(`/products/${id}`, { name: editName, stock: editStock });
      setProducts((prev) => prev.map((p) => (p.id === id ? res.data : p)));
      cancelEdit();
    } catch (e) {
      alert(e.response?.data?.message || e.message || "Update failed");
    }
  }

  async function deleteProduct(id) {
    if (!confirm("Supprimer ce produit ?")) return;

    try {
      await api.delete(`/products/${id}`);
      setProducts((prev) => prev.filter((p) => p.id !== id));
    } catch (e) {
      alert(e.response?.data?.message || e.message || "Delete failed");
    }
  }

  async function createProduct(e) {
    e.preventDefault();
    try {
      const payload = {
        name: newName,
        description: newDescription,
        price: newPrice || null,
        stock: newStock || 0,
      };

      const res = await api.post(`/products`, payload);
      setProducts((prev) => [res.data, ...prev]);

      // Reset form
      setNewName("");
      setNewDescription("");
      setNewPrice("");
      setNewStock("");
    } catch (e) {
      alert(e.response?.data?.message || e.message || "Create failed");
    }
  }

  if (loading) return <p style={{ padding: 20 }}>Chargement...</p>;
  if (error) return <p style={{ padding: 20, color: "red" }}>Erreur: {error}</p>;

  return (
    <div style={{ padding: 5 }}>
      <h2 style={h2}>User - Products</h2>

      

      <table style={table}>
        <thead>
          <tr>
            <th style={th}>ID</th>
            <th style={th}>Name</th>
            <th style={th}>Stock</th>
            <th style={th}>Price</th>
            <th style={th}>Actions</th>
          </tr>
        </thead>

        <tbody>
          {products.map((p) => (
            <tr key={p.id}>
              <td style={td}>{p.id}</td>

              <td style={td}>
                {editingId === p.id ? (
                  <input value={editName} onChange={(e) => setEditName(e.target.value)} />
                ) : (
                  p.name
                )}
              </td>

              <td style={td}>
                {editingId === p.id ? (
                  <input type="number" value={editStock} onChange={(e) => setEditStock(e.target.value)} />
                ) : (
                  p.stock
                )}
              </td>

              <td style={td}>{p.price ?? "-"}</td>

              <td style={td}>
                {editingId === p.id ? (
                  <>
                    <button onClick={() => saveEdit(p.id)} style={btn}>Save</button>
                    <button onClick={cancelEdit} style={btn2}>Cancel</button>
                  </>
                ) : (
                  <>
                    <button onClick={() => startEdit(p)} style={btn}>Edit</button>
                    <button onClick={() => deleteProduct(p.id)} style={btnDanger}>Delete</button>
                  </>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      <button onClick={fetchProducts} style={{ marginTop: 12 }}>
        Refresh
      </button>
      <div>
      <hr />
<div style={{ marginBottom: 12 }}>
        {!showNewForm ? (
          <button type="button" onClick={() => { setShowNewForm(true); setTimeout(() => newNameRef.current?.focus(), 0); }}>Add Product</button>
        ) : (
          <form onSubmit={createProduct} style={{ display: "flex", gap: 8, alignItems: "center", flexWrap: "wrap" }}>
            <input ref={newNameRef} placeholder="Name" value={newName} onChange={(e) => setNewName(e.target.value)} required />
            <input placeholder="Description" value={newDescription} onChange={(e) => setNewDescription(e.target.value)} />
            <input type="number" placeholder="Price" value={newPrice} onChange={(e) => setNewPrice(e.target.value)} />
            <input type="number" placeholder="Stock" value={newStock} onChange={(e) => setNewStock(e.target.value)} />
            <button type="submit">Create</button>
            <button type="button" onClick={() => setShowNewForm(false)}>Cancel</button>
          </form>
        )}
      </div>

      </div>
      
<hr />


    </div>
  );
}


const table = { width: "100%", borderCollapse: "collapse" };
const th = { border: "1px solid #ddd", padding: 10, background: "#f3f4f6", textAlign: "center",fontWeight: "bold",fontSize: 16 };
const td = { border: "1px solid #f1ee14", padding: 10 ,color:"white",textAlign: "center",fontWeight: "bold",fontSize: 16 };
const btn = { marginRight: 8 };
const btn2 = { marginRight: 8 };
const btnDanger = { marginRight: 8 };
const h2 = { color: "white" };
