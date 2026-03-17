<template>
  <div class="messages-page">

    <!-- Loading -->
    <div v-if="loading" class="loading-screen">
      <div class="spinner"></div>
    </div>

    <div v-else class="messages-layout">

      <!-- ══════════ SIDEBAR ══════════ -->
      <div class="sidebar" :class="{ 'sidebar-hidden': activeChatId && isMobile }">

        <div class="sidebar-header">
          <h1 class="page-title">Messages</h1>
          <div class="search-wrap">
            <input v-model="search" type="text" class="search-input" placeholder="Rechercher..." />
            <span class="search-icon">🔍</span>
          </div>
        </div>

        <div class="conv-list">
          <div v-if="convError" class="no-conv error-msg">⚠️ {{ convError }}</div>
          <div v-else-if="filteredConversations.length === 0" class="no-conv">
            Aucune conversation.
          </div>
          <div
            v-for="conv in filteredConversations"
            :key="conv.userId"
            class="conv-item"
            :class="{ active: activeChatId === conv.userId }"
            @click="openChat(conv)"
          >
            <div class="conv-avatar-wrap">
              <div class="conv-avatar">{{ initials(conv.name) }}</div>
              <span v-if="conv.online" class="online-dot"></span>
              <span v-if="conv.unread > 0" class="unread-badge">{{ conv.unread }}</span>
            </div>
            <div class="conv-info">
              <div class="conv-top">
                <span class="conv-name">{{ conv.name }}</span>
                <span class="conv-time">{{ conv.time }}</span>
              </div>
              <div class="conv-preview">{{ conv.lastMessage || '—' }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- ══════════ CHAT AREA ══════════ -->
      <div class="chat-area" :class="{ 'chat-visible': activeChatId || !isMobile }">

        <div v-if="!activeChatId" class="empty-chat">
          <div class="empty-icon">💬</div>
          <p>Sélectionnez une conversation</p>
        </div>

        <template v-else>
          <div class="chat-header">
            <button v-if="isMobile" class="back-chat-btn" @click="closeChat">←</button>
            <div class="chat-avatar">{{ initials(activeConv?.name ?? '') }}</div>
            <div class="chat-header-info">
              <div class="chat-name">{{ activeConv?.name }}</div>
              <div class="chat-spec">{{ activeConv?.speciality || 'Artisan' }}</div>
            </div>
            <div class="chat-actions">
              <button class="chat-action-btn" title="Appeler">📞</button>
              <button class="chat-action-btn" title="Vidéo">📹</button>
              <button class="chat-action-btn danger" title="Signaler">🚨</button>
            </div>
          </div>

          <div class="messages-body" ref="messagesBody">
            <div v-if="msgLoading" class="msg-loading"><div class="spinner small"></div></div>
            <div v-else-if="msgError" class="msg-error">⚠️ {{ msgError }}</div>
            <template v-else>
              <div
                v-for="(msg, i) in messages"
                :key="msg.id ?? i"
                class="msg-row"
                :class="msg.isMine ? 'mine' : 'theirs'"
              >
                <div class="bubble" :class="msg.isMine ? 'bubble-mine' : 'bubble-theirs'">
                  <p class="bubble-text">{{ msg.body }}</p>
                  <span class="bubble-time">{{ msg.time }}</span>
                </div>
              </div>
            </template>
          </div>

          <!-- Send error banner -->
          <div v-if="sendError" class="send-error-bar" @click="sendError = ''">
            ⚠️ {{ sendError }} <span class="send-error-close">✕</span>
          </div>

          <div class="chat-input-bar">
            <button class="input-action-btn" title="Pièce jointe">📎</button>
            <button class="input-action-btn" title="Image">🖼</button>
            <input
              v-model="newMessage"
              type="text"
              class="msg-input"
              placeholder="Écrivez votre message..."
              @keydown.enter="sendMessage"
            />
            <button class="send-btn" @click="sendMessage" :disabled="sendLoading">
              <span v-if="sendLoading">⏳</span>
              <span v-else>➤</span>
            </button>
          </div>
        </template>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, nextTick, watch } from 'vue'

const API_BASE = 'http://127.0.0.1:8000/api'

function getToken() {
  return localStorage.getItem('token') || ''
}
function getMe() {
  try { return JSON.parse(localStorage.getItem('user') || '{}') } catch { return {} }
}

const loading       = ref(true)
const convError     = ref('')
const conversations = ref([])
const search        = ref('')
const activeChatId  = ref(null)
const activeConv    = ref(null)
const messages      = ref([])
const msgError      = ref('')
const newMessage    = ref('')
const msgLoading    = ref(false)
const sendLoading   = ref(false)
const sendError     = ref('')
const messagesBody  = ref(null)
const isMobile      = ref(window.innerWidth < 768)

window.addEventListener('resize', () => { isMobile.value = window.innerWidth < 768 })

const filteredConversations = computed(() => {
  if (!search.value.trim()) return conversations.value
  return conversations.value.filter(c =>
    c.name.toLowerCase().includes(search.value.toLowerCase()) ||
    (c.lastMessage || '').toLowerCase().includes(search.value.toLowerCase())
  )
})

// ── Fetch conversations ────────────────────────────────
async function fetchConversations() {
  loading.value   = true
  convError.value = ''
  try {
    const res  = await fetch(`${API_BASE}/messages/conversations`, {
      headers: { 'Authorization': `Bearer ${getToken()}`, 'Accept': 'application/json' }
    })
    const data = await res.json()
    console.log('📨 conversations raw:', data)

    if (!res.ok) {
      convError.value = data.message ?? `Erreur ${res.status}`
      return
    }

    // Handle every possible shape Laravel might return
    let list = []
    if (Array.isArray(data))                    list = data
    else if (Array.isArray(data.conversations)) list = data.conversations
    else if (Array.isArray(data.data))          list = data.data
    else if (typeof data === 'object' && data !== null) list = Object.values(data)

    conversations.value = list.map(c => {
      const other   = c.other_user ?? c.user ?? c.contact ?? {}
      const userId  = other.id ?? c.user_id ?? c.other_user_id ?? c.receiver_id ?? c.sender_id
      const lastMsg = c.last_message
        ?? c.latest_message?.body
        ?? c.latest_message?.message
        ?? c.latest_message?.content
        ?? c.body ?? c.message ?? c.content ?? ''

      return {
        userId,
        name:        other.name ?? c.name ?? 'Utilisateur',
        speciality:  other.speciality ?? other.artisanProfile?.specialite ?? c.speciality ?? '',
        lastMessage: lastMsg,
        time:        formatTime(c.last_message_at ?? c.updated_at ?? c.created_at),
        unread:      c.unread_count ?? 0,
        online:      c.online ?? false,
      }
    }).filter(c => c.userId != null)

    console.log('✅ conversations mapped:', conversations.value)

  } catch (e) {
    console.error('❌ fetchConversations error:', e)
    convError.value = 'Impossible de charger les conversations.'
  } finally {
    loading.value = false
  }
}

// ── Open chat ──────────────────────────────────────────
async function openChat(conv) {
  activeChatId.value = conv.userId
  activeConv.value   = conv
  msgLoading.value   = true
  msgError.value     = ''
  messages.value     = []

  try {
    const res  = await fetch(`${API_BASE}/messages/conversation/${conv.userId}`, {
      headers: { 'Authorization': `Bearer ${getToken()}`, 'Accept': 'application/json' }
    })
    const data = await res.json()
    console.log('💬 messages raw:', data)

    if (!res.ok) { msgError.value = data.message ?? `Erreur ${res.status}`; return }

    const me   = getMe()
    const list = Array.isArray(data) ? data : (data.messages ?? data.data ?? Object.values(data))

    messages.value = list.map(m => ({
      id:     m.id,
      body:   m.body ?? m.message ?? m.content ?? '',
      time:   formatTime(m.created_at),
      isMine: Number(m.sender_id ?? m.from_id) === Number(me.id),
    }))

    conv.unread = 0
    scrollBottom()

  } catch (e) {
    console.error('❌ openChat error:', e)
    msgError.value = 'Impossible de charger les messages.'
  } finally {
    msgLoading.value = false
  }
}

function closeChat() {
  activeChatId.value = null
  activeConv.value   = null
}

// ── Send message ───────────────────────────────────────
async function sendMessage() {
  const text = newMessage.value.trim()
  if (!text || sendLoading.value) return

  sendError.value   = ''
  newMessage.value  = ''
  sendLoading.value = true

  // Optimistic bubble
  const tempMsg = { id: Date.now(), body: text, time: "à l'instant", isMine: true, pending: true }
  messages.value.push(tempMsg)
  scrollBottom()

  try {
    const payload = {
      receiver_id: activeChatId.value,  // int or string — Laravel will cast
      body:        text,                 // tried first
      message:     text,                 // fallback field name
      content:     text,                 // another fallback
    }

    const res  = await fetch(`${API_BASE}/messages/send`, {
      method: 'POST',
      headers: {
        'Content-Type':  'application/json',
        'Authorization': `Bearer ${getToken()}`,
        'Accept':        'application/json',
      },
      body: JSON.stringify(payload),
    })

    const data = await res.json().catch(() => ({}))
    console.log('📤 send response:', res.status, data)

    if (!res.ok) {
      // Show the real Laravel error message
      const errMsg = data.errors
        ? Object.values(data.errors).flat().join(' ')
        : (data.message ?? `Erreur ${res.status}`)
      sendError.value = errMsg
      // Remove optimistic bubble
      messages.value = messages.value.filter(m => m.id !== tempMsg.id)
      newMessage.value = text   // restore text so user can retry
      return
    }

    // Replace temp with real message from server
    const saved = data.message ?? data.data ?? data
    const idx   = messages.value.findIndex(m => m.id === tempMsg.id)
    if (idx !== -1 && saved?.id) {
      messages.value[idx] = {
        id:     saved.id,
        body:   saved.body ?? saved.message ?? saved.content ?? text,
        time:   formatTime(saved.created_at),
        isMine: true,
      }
    } else {
      // Mark as confirmed
      if (idx !== -1) delete messages.value[idx].pending
    }

    // Update sidebar preview
    const conv = conversations.value.find(c => c.userId === activeChatId.value)
    if (conv) { conv.lastMessage = text; conv.time = "à l'instant" }

  } catch (e) {
    console.error('❌ sendMessage error:', e)
    sendError.value = 'Erreur réseau. Vérifiez votre connexion.'
    messages.value = messages.value.filter(m => m.id !== tempMsg.id)
    newMessage.value = text
  } finally {
    sendLoading.value = false
  }
}

function initials(name = '') {
  return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2) || '?'
}

function formatTime(iso) {
  if (!iso) return ''
  const d = new Date(iso), now = new Date(), diff = now - d
  if (diff < 60000)    return "à l'instant"
  if (diff < 3600000)  return Math.floor(diff / 60000) + ' min'
  if (diff < 86400000) return d.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
  const yesterday = new Date(now); yesterday.setDate(now.getDate() - 1)
  if (d.toDateString() === yesterday.toDateString()) return 'Hier'
  return d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' })
}

async function scrollBottom() {
  await nextTick()
  if (messagesBody.value) messagesBody.value.scrollTop = messagesBody.value.scrollHeight
}

watch(messages, scrollBottom)
onMounted(fetchConversations)
</script>

<style scoped>
.messages-page {
  padding-top: 111px;
  background: #f7f8fa;
  min-height: 100vh;
  font-family: 'Segoe UI', 'Helvetica Neue', sans-serif;
  color: #1f2a44;
  display: flex;
  flex-direction: column;
}
.loading-screen {
  flex: 1; display: flex;
  align-items: center; justify-content: center;
  min-height: 60vh;
}
.messages-layout {
  display: flex; flex: 1;
  height: calc(100vh - 111px);
  max-width: 1320px; margin: 0 auto;
  width: 100%; padding: 24px 20px;
  gap: 20px; box-sizing: border-box;
}

/* Sidebar */
.sidebar {
  width: 340px; flex-shrink: 0;
  background: #fff; border-radius: 16px;
  box-shadow: 0 2px 16px rgba(0,0,0,0.07);
  display: flex; flex-direction: column; overflow: hidden;
}
.sidebar-header { padding: 20px 20px 12px; border-bottom: 1px solid #f0f0f0; }
.page-title { font-size: 1.5rem; font-weight: 900; color: #1f2a44; margin: 0 0 14px; }
.search-wrap { position: relative; }
.search-input {
  width: 100%; padding: 10px 40px 10px 16px;
  border: 1.5px solid #e8e8e8; border-radius: 999px;
  font-size: 0.85rem; font-weight: 600; color: #1f2a44;
  outline: none; transition: border .2s;
  box-sizing: border-box; background: #f7f8fa;
}
.search-input:focus { border-color: #ff5a17; background: #fff; }
.search-icon {
  position: absolute; right: 14px; top: 50%;
  transform: translateY(-50%); font-size: 0.85rem; opacity: .5;
}
.conv-list { flex: 1; overflow-y: auto; }
.conv-list::-webkit-scrollbar { width: 4px; }
.conv-list::-webkit-scrollbar-thumb { background: #e8e8e8; border-radius: 4px; }
.no-conv {
  padding: 32px 20px; text-align: center;
  color: rgba(31,42,68,0.4); font-size: 0.85rem; font-weight: 700;
}
.error-msg { color: #e53935 !important; }
.conv-item {
  display: flex; align-items: center; gap: 12px;
  padding: 14px 20px; cursor: pointer;
  border-bottom: 1px solid #f5f5f5; transition: background .15s;
}
.conv-item:hover  { background: #fdf4f0; }
.conv-item.active { background: #fff3ee; border-left: 3px solid #ff5a17; }
.conv-avatar-wrap { position: relative; flex-shrink: 0; }
.conv-avatar {
  width: 46px; height: 46px; border-radius: 50%;
  background: rgba(255,90,23,0.12); color: #ff5a17;
  font-weight: 900; font-size: 0.9rem;
  display: flex; align-items: center; justify-content: center;
}
.online-dot {
  position: absolute; bottom: 2px; right: 2px;
  width: 10px; height: 10px; background: #22c55e;
  border-radius: 50%; border: 2px solid #fff;
}
.unread-badge {
  position: absolute; top: -2px; right: -4px;
  background: #ff5a17; color: #fff;
  font-size: 0.65rem; font-weight: 900;
  border-radius: 999px; padding: 1px 5px;
  min-width: 16px; text-align: center;
}
.conv-info { flex: 1; min-width: 0; }
.conv-top { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 3px; }
.conv-name { font-size: 0.9rem; font-weight: 900; color: #1f2a44; }
.conv-time { font-size: 0.72rem; color: rgba(31,42,68,0.4); font-weight: 700; flex-shrink: 0; margin-left: 8px; }
.conv-preview {
  font-size: 0.78rem; color: rgba(31,42,68,0.5); font-weight: 600;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

/* Chat */
.chat-area {
  flex: 1; background: #fff; border-radius: 16px;
  box-shadow: 0 2px 16px rgba(0,0,0,0.07);
  display: flex; flex-direction: column;
  overflow: hidden; min-width: 0;
}
.empty-chat {
  flex: 1; display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  color: rgba(31,42,68,0.3); gap: 10px;
}
.empty-icon { font-size: 3rem; }
.empty-chat p { font-size: 0.9rem; font-weight: 700; }

.chat-header {
  display: flex; align-items: center; gap: 12px;
  padding: 16px 20px; border-bottom: 1px solid #f0f0f0; flex-shrink: 0;
}
.chat-avatar {
  width: 42px; height: 42px; border-radius: 50%;
  background: rgba(255,90,23,0.12); color: #ff5a17;
  font-weight: 900; font-size: 0.9rem;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.chat-header-info { flex: 1; }
.chat-name { font-size: 0.95rem; font-weight: 900; color: #1f2a44; }
.chat-spec { font-size: 0.75rem; color: rgba(31,42,68,0.5); font-weight: 700; }
.chat-actions { display: flex; gap: 8px; }
.chat-action-btn {
  width: 36px; height: 36px; border-radius: 50%;
  border: none; background: #f7f8fa; cursor: pointer;
  font-size: 1rem; display: flex; align-items: center; justify-content: center;
  transition: background .2s;
}
.chat-action-btn:hover { background: #f0f0f0; }
.chat-action-btn.danger { background: rgba(239,68,68,0.1); }
.back-chat-btn {
  background: none; border: none; font-size: 1.2rem;
  cursor: pointer; color: #1f2a44; padding: 0 4px; font-weight: 900;
}

.messages-body {
  flex: 1; overflow-y: auto; padding: 20px;
  display: flex; flex-direction: column; gap: 12px;
}
.messages-body::-webkit-scrollbar { width: 4px; }
.messages-body::-webkit-scrollbar-thumb { background: #e8e8e8; border-radius: 4px; }
.msg-loading { flex: 1; display: flex; align-items: center; justify-content: center; }
.msg-error   { flex: 1; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; color: #e53935; font-weight: 700; }

.msg-row { display: flex; }
.msg-row.mine   { justify-content: flex-end; }
.msg-row.theirs { justify-content: flex-start; }
.bubble { max-width: 65%; padding: 12px 16px; border-radius: 18px; }
.bubble-mine   { background: #ff5a17; border-bottom-right-radius: 4px; }
.bubble-theirs { background: #f7f8fa; border-bottom-left-radius: 4px; border: 1px solid #f0f0f0; }
.bubble-text { font-size: 0.88rem; font-weight: 600; line-height: 1.5; margin: 0 0 4px; color: #1f2a44; }
.bubble-mine .bubble-text { color: #fff; }
.bubble-time { font-size: 0.68rem; opacity: .65; font-weight: 700; display: block; text-align: right; color: #1f2a44; }
.bubble-mine .bubble-time { color: #fff; }

.send-error-bar {
  padding: 10px 20px; background: rgba(239,68,68,0.08);
  border-top: 1px solid rgba(239,68,68,0.2);
  color: #dc2626; font-size: 0.82rem; font-weight: 700;
  cursor: pointer; display: flex; justify-content: space-between;
  align-items: center; flex-shrink: 0;
}
.send-error-bar:hover { background: rgba(239,68,68,0.13); }
.send-error-close { font-size: 0.9rem; opacity: .6; }

.chat-input-bar {
  display: flex; align-items: center; gap: 8px;
  padding: 14px 20px; border-top: 1px solid #f0f0f0; flex-shrink: 0;
}
.input-action-btn {
  width: 36px; height: 36px; border-radius: 50%;
  border: none; background: none; cursor: pointer; font-size: 1.1rem;
  display: flex; align-items: center; justify-content: center;
  color: rgba(31,42,68,0.4); transition: color .2s; flex-shrink: 0;
}
.input-action-btn:hover { color: #ff5a17; }
.msg-input {
  flex: 1; padding: 11px 18px;
  border: 1.5px solid #e8e8e8; border-radius: 999px;
  font-size: 0.88rem; font-weight: 600; color: #1f2a44;
  outline: none; transition: border .2s; min-width: 0;
}
.msg-input:focus { border-color: #ff5a17; }
.send-btn {
  width: 42px; height: 42px; border-radius: 50%;
  background: #ff5a17; color: #fff; border: none;
  cursor: pointer; font-size: 1rem;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; transition: background .2s;
}
.send-btn:hover    { background: #ff4a05; }
.send-btn:disabled { opacity: .6; cursor: not-allowed; }

.spinner {
  width: 36px; height: 36px;
  border: 3px solid #f0f0f0; border-top-color: #ff5a17;
  border-radius: 50%; animation: spin .7s linear infinite;
}
.spinner.small { width: 24px; height: 24px; border-width: 2px; }
@keyframes spin { to { transform: rotate(360deg); } }

/* Responsive */
@media (max-width: 767px) {
  .messages-layout {
    padding: 0; gap: 0;
    height: calc(100vh - 111px);
    position: relative;
  }
  .sidebar {
    width: 100%; border-radius: 0;
    position: absolute; inset: 0;
    z-index: 10; transition: transform .3s ease;
  }
  .sidebar-hidden { transform: translateX(-100%); pointer-events: none; }
  .chat-area {
    border-radius: 0; position: absolute; inset: 0;
    z-index: 20; transform: translateX(100%);
    transition: transform .3s ease;
  }
  .chat-visible { transform: translateX(0); }
  .bubble { max-width: 80%; }
  .page-title { font-size: 1.2rem; }
}
@media (min-width: 768px) and (max-width: 1024px) {
  .sidebar { width: 260px; }
  .messages-layout { padding: 16px; }
}
</style>