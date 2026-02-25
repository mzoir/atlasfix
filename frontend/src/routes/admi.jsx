import { useEffect, useState, useRef } from "react";
import api from "./api.js";
import { logout } from "./logout.js";
import Produit from "./produit.jsx";

export default function Admin() {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  const [editingId, setEditingId] = useState(null);
  const [editTitle, setEditTitle] = useState("");
  const [editStatus, setEditStatus] = useState("pending");
  const [userName, setUserName] = useState("");

  // New task form state
  const [showNewForm, setShowNewForm] = useState(false);
  const newTitleRef = useRef(null);
  const [newTitle, setNewTitle] = useState("");
  const [newDescription, setNewDescription] = useState("");
  const [newDueDate, setNewDueDate] = useState("");
  const [newStatus, setNewStatus] = useState("pending");
 
  async function fetchTasks() {
    try {
      setLoading(true);
      setError("");

      const res = await api.get("/tasks");
      setTasks(res.data || []);
    } catch (e) {
      setError(e.response?.data?.message || e.message || "Erreur lors du chargement");
    } finally {
      setLoading(false);
    }
  }

  async function fetchUser() {
    try {
      const res = await api.get("/user");
      const name = res.data?.name ?? res.data?.user?.name ?? "";
      setUserName(name);
    } catch (e) {
      console.error("fetchUser:", e.response?.data || e.message);
    }
  }

  useEffect(() => {
    fetchTasks();
    fetchUser();
  }, []);

  function startEdit(t) {
    setEditingId(t.id);
    setEditTitle(t.title || "");
    setEditStatus(t.status || "pending");
  }

  function cancelEdit() {
    setEditingId(null);
    setEditTitle("");
    setEditStatus("pending");
  }

  async function saveEdit(id) {
    try {
      const res = await api.put(`/tasks/${id}`, { title: editTitle, status: editStatus });
      setTasks((prev) => prev.map((t) => (t.id === id ? res.data : t)));
      cancelEdit();
    } catch (e) {
      alert(e.response?.data?.message || e.message || "Update failed");
    }
  }

  async function deleteTask(id) {
    if (!confirm("Supprimer cette tâche ?")) return;

    try {
      await api.delete(`/tasks/${id}`);
      setTasks((prev) => prev.filter((t) => t.id !== id));
    } catch (e) {
      alert(e.response?.data?.message || e.message || "Delete failed");
    }
  }

  async function createTask(e) {
    e.preventDefault();
    try {
      const payload = {
        title: newTitle,
        description: newDescription,
        due_date: newDueDate || null,
        status: newStatus,
      };

      const res = await api.post(`/tasks`, payload);
      setTasks((prev) => [res.data, ...prev]);

      // Reset form
      setNewTitle("");
      setNewDescription("");
      setNewDueDate("");
      setNewStatus("pending");
    } catch (e) {
      alert(e.response?.data?.message || e.message || "Create failed");
    }
  }

  if (loading) return <p style={{ padding: 20 }}>Chargement...</p>;
  if (error) return <p style={{ padding: 20, color: "red" }}>Erreur: {error}</p>;

  return (
    <div style={{ padding: 20 }}>
      <div style={{ textAlign: "center", color: "white", fontSize: 20, fontWeight: "bold" }}>Bonjour: {userName}</div>
      <h2 style={h2} >User - Tasks</h2>

      

      <table style={table}>
        <thead>
          <tr>
            <th style={th}>ID</th>
            <th style={th}>Titre</th>
            <th style={th}>Status</th>
            <th style={th}>Due date</th>
            <th style={th}>Actions</th>
          </tr>
        </thead>

        <tbody>
          {tasks.map((t) => (
            <tr key={t.id}>
              <td style={td}>{t.id}</td>

              <td style={td}>
                {editingId === t.id ? (
                  <input value={editTitle} onChange={(e) => setEditTitle(e.target.value)} />
                ) : (
                  t.title
                )}
              </td>

              <td style={td}>
                {editingId === t.id ? (
                  <select value={editStatus} onChange={(e) => setEditStatus(e.target.value)}>
                    <option value="pending">pending</option>
                    <option value="in_progress">in_progress</option>
                    <option value="completed">completed</option>
                  </select>
                ) : (
                  t.status
                )}
              </td>

              <td style={td}>{t.due_date ?? "-"}</td>

              <td style={td}>
                {editingId === t.id ? (
                  <>
                    <button onClick={() => saveEdit(t.id)} style={btn}>Save</button>
                    <button onClick={cancelEdit} style={btn2}>Cancel</button>
                  </>
                ) : (
                  <>
                    <button onClick={() => startEdit(t)} style={btn}>Edit</button>
                    <button onClick={() => deleteTask(t.id)} style={btnDanger}>Delete</button>
                  </>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      <button onClick={fetchTasks} style={{ marginTop: 12 }}>
        Refresh
      </button>
      
      <div>
      <hr />
<div style={{ marginBottom: 12 }}>
        {!showNewForm ? (
          <button type="button" onClick={() => { setShowNewForm(true); setTimeout(() => newTitleRef.current?.focus(), 0); }}>Add Task</button>
        ) : (
          <form onSubmit={createTask} style={{ display: "flex", gap: 8, alignItems: "center", flexWrap: "wrap" }}>
            <input ref={newTitleRef} placeholder="Title" value={newTitle} onChange={(e) => setNewTitle(e.target.value)} required />
            <input placeholder="Description" value={newDescription} onChange={(e) => setNewDescription(e.target.value)} />
            <input type="date" value={newDueDate} onChange={(e) => setNewDueDate(e.target.value)} />
            <select value={newStatus} onChange={(e) => setNewStatus(e.target.value)}>
              <option value="pending">pending</option>
              <option value="in_progress">in_progress</option>
              <option value="completed">completed</option>
            </select>
            <button type="submit">Create</button>
            <button type="button" onClick={() => setShowNewForm(false)}>Cancel</button>
          </form>
        )}
      </div>

      </div>
   
<Produit />


   

      <a href={logout}  style={{color: "red"}}>
        Log Out
      </a>


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

