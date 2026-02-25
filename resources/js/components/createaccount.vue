<template>
  <div class="page">
    <section class="frame">
      <!-- ====== TOP BAR (Back) ====== -->
      <button class="back" type="button" @click="goBack">
        ← Retour
      </button>

      <!-- ====== VIEW 1 : CHOOSE ROLE ====== -->
      <div v-if="view === 'choose'" class="choose">
        <div class="head">
          <h1>Créer un compte</h1>
          <p>Choisissez le type de compte qui vous correspond</p>
        </div>

        <div class="cards">
          <!-- Client -->
          <article class="card">
            <div class="iconBox"><span class="icon">👤</span></div>
            <h2>Je suis un Client</h2>
            <p class="desc">
              Trouvez des artisans qualifiés pour tous vos projets de rénovation et d’entretien
            </p>
            <ul class="list">
              <li><span class="check">✓</span> Accès à des centaines d’artisans certifiés</li>
              <li><span class="check">✓</span> Comparez les devis rapidement</li>
              <li><span class="check">✓</span> Consultez les avis et notes des artisans</li>
              <li><span class="check">✓</span> Service client disponible 7j/7</li>
            </ul>
            <button class="cta" type="button" @click="view='client'">Se connecter</button>
          </article>

          <!-- Artisan -->
          <article class="card">
            <div class="iconBox"><span class="icon">🔧</span></div>
            <h2>Je suis un Artisan</h2>
            <p class="desc">
              Développez votre activité et trouvez de nouveaux clients en rejoignant notre plateforme
            </p>
            <ul class="list">
              <li><span class="check">✓</span> Recevez des demandes de clients locaux</li>
              <li><span class="check">✓</span> Créez votre profil et portfolio</li>
              <li><span class="check">✓</span> Gérez vos interventions facilement</li>
              <li><span class="check">✓</span> Construisez votre réputation en ligne</li>
            </ul>
            <button class="cta" type="button" @click="view='artisan'">Se connecter</button>
          </article>
        </div>
      </div>

      <!-- ====== VIEW 2 : CLIENT FORM ====== -->
      <div v-else-if="view === 'client'" class="client">
        <div class="head">
          <h1>Créer un compte Client</h1>
          <p>Rejoignez notre plateforme et trouvez les meilleurs artisans</p>
        </div>

        <div class="formWrap">
          <form class="formCard" @submit.prevent="submitClient">
            <!-- Nom -->
            <label class="lbl">
              <span class="lblRow"><span class="ico">👤</span> Nom complet <b>*</b></span>
              <input v-model.trim="client.nom" type="text" placeholder="Ex: Ahmed El Amrani" required />
            </label>

            <!-- Email -->
            <label class="lbl">
              <span class="lblRow"><span class="ico">✉️</span> Adresse email <b>*</b></span>
              <input v-model.trim="client.email" type="email" placeholder="exemple@email.com" required />
            </label>

            <!-- Phone -->
            <label class="lbl">
              <span class="lblRow"><span class="ico">📞</span> Numéro de téléphone <b>*</b></span>
              <input v-model.trim="client.phone" type="tel" placeholder="06 XX XX XX XX" required />
            </label>

            <!-- Birth -->
            <label class="lbl">
              <span class="lblRow"><span class="ico">📅</span> Date de naissance <b>*</b></span>
              <div class="inputWithIcon">
                <input v-model.trim="client.birth" type="text" placeholder="jj/mm/aaaa" required />
                <span class="rightIcon">📅</span>
              </div>
            </label>

            <!-- Ville -->
            <label class="lbl">
              <span class="lblRow"><span class="ico">📍</span> Ville <b>*</b></span>
              <div class="inputWithIcon">
                <select v-model="client.ville" required>
                  <option value="" disabled>Ville</option>
                  <option>Casablanca</option>
                  <option>Rabat</option>
                  <option>Fès</option>
                  <option>Marrakech</option>
                  <option>Tanger</option>
                </select>
                <span class="rightIcon">▾</span>
              </div>
            </label>

            <!-- Adresse + localiser -->
            <label class="lbl">
              <span class="lblRow"><span class="ico">🏠</span> Adresse <b>*</b></span>
              <div class="addrRow">
                <input v-model.trim="client.address" type="text" placeholder="Adresse complète" required />
                <button class="locBtn" type="button" @click="mockLocate">Me localiser</button>
              </div>
            </label>

            <!-- Password -->
            <label class="lbl">
              <span class="lblRow"><span class="ico">🔒</span> Mot de passe <b>*</b></span>
              <div class="inputWithIcon">
                <input
                  v-model="client.pass"
                  :type="showPass ? 'text' : 'password'"
                  placeholder="Minimum 8 caractères"
                  minlength="8"
                  required
                />
                <button class="eye" type="button" @click="showPass = !showPass">
                  {{ showPass ? '🙈' : '👁️' }}
                </button>
              </div>
            </label>

            <!-- Confirm -->
            <label class="lbl">
              <span class="lblRow"><span class="ico">🔒</span> Confirmer le mot de passe <b>*</b></span>
              <div class="inputWithIcon">
                <input
                  v-model="client.pass2"
                  :type="showPass2 ? 'text' : 'password'"
                  placeholder="Retapez votre mot de passe"
                  minlength="8"
                  required
                />
                <button class="eye" type="button" @click="showPass2 = !showPass2">
                  {{ showPass2 ? '🙈' : '👁️' }}
                </button>
              </div>
            </label>

            <!-- Terms -->
            <div class="terms">
              <input id="t" v-model="client.accept" type="checkbox" />
              <label for="t">
                J’accepte les <span class="link">conditions générales d’utilisation</span> et la
                <span class="link">politique de confidentialité</span>
              </label>
            </div>

            <button class="submit" type="submit">Créer mon compte</button>
          </form>

          <!-- Info card -->
          <aside class="whyCard">
            <h3>Pourquoi créer un compte ?</h3>
            <ul>
              <li><span class="dot">✓</span> Créez et gérez vos demandes de service facilement</li>
              <li><span class="dot">✓</span> Recevez des devis de plusieurs artisans qualifiés</li>
              <li><span class="dot">✓</span> Suivez l’état de vos demandes en temps réel</li>
              <li><span class="dot">✓</span> Communiquez directement avec les artisans via la messagerie</li>
              <li><span class="dot">✓</span> Consultez votre historique de demandes et d’avis</li>
            </ul>
          </aside>
        </div>
      </div>

      <!-- ====== VIEW 3 : ARTISAN (placeholder) ====== -->
      <div v-else class="artisan">
        <div class="head">
          <h1>Créer un compte Artisan</h1>
          <p>(On ajoute ce formulaire après)</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";

const view = ref("choose"); // choose | client | artisan

const showPass = ref(false);
const showPass2 = ref(false);

const client = reactive({
  nom: "",
  email: "",
  phone: "",
  birth: "",
  ville: "",
  address: "",
  pass: "",
  pass2: "",
  accept: false,
});

const goBack = () => {
  if (view.value === "choose") {
    // si tu veux revenir route précédente:
    // history.back()
    return;
  }
  view.value = "choose";
};

const mockLocate = () => {
  // plus tard: navigator.geolocation
  client.address = "Ex: Bd d'Anfa, Casablanca";
};

const submitClient = () => {
  if (!client.accept) {
    alert("Veuillez accepter les conditions.");
    return;
  }
  if (client.pass !== client.pass2) {
    alert("Les mots de passe ne correspondent pas.");
    return;
  }

  // ici tu peux appeler ton API
  console.log("CLIENT REGISTER:", JSON.parse(JSON.stringify(client)));
  alert("OK (démo) ✅");
};
</script>

<style scoped>
/* background */
.page{
  min-height: 100vh;
  background:#0c0f13;
  display:flex;
  justify-content:center;
  align-items:flex-start;
}

/* Figma frame */
.frame{
  position: relative;
  width: 1152px;
  height: 872px;
  top: 102px;
  left: 144px;
}

/* back */
.back{
  position:absolute;
  top: 12px;
  left: 0;
  background: transparent;
  border: 0;
  color: #aab4c1;
  font-size: 14px;
  cursor: pointer;
}

/* header */
.head{
  position: absolute;
  top: 56px;
  left: 0;
  width: 100%;
  text-align:center;
}
.head h1{
  margin:0;
  color:#9fb0c7;
  font-weight: 800;
  font-size: 46px;
  letter-spacing:-0.5px;
}
.head p{
  margin: 10px 0 0;
  color:#6f7f93;
  font-size: 16px;
}

/* ===== choose view ===== */
.choose .cards{
  position:absolute;
  top: 200px;
  left: 0;
  width: 100%;
  display:flex;
  gap: 40px;
  justify-content:center;
}

.card{
  width: 520px;
  border-radius: 22px;
  background:#ffffff;
  box-shadow: 0 20px 60px rgba(0,0,0,.35);
  padding: 34px 34px 26px;
  position: relative;
  overflow:hidden;
}
.card::after{
  content:"";
  position:absolute;
  top:-60px;
  right:-60px;
  width:160px;
  height:160px;
  border-radius:999px;
  background: rgba(255, 153, 120, 0.18);
}
.iconBox{
  width:56px;height:56px;border-radius:14px;
  background:#ff5a1f;
  display:flex;align-items:center;justify-content:center;
  margin-bottom: 18px;
}
.icon{font-size:22px;color:#fff}
.card h2{margin:0;font-size:34px;color:#1b2430}
.desc{margin:10px 0 18px;color:#5b6b7c;font-size:15px;line-height:1.5}
.list{list-style:none;padding:0;margin:0 0 22px;display:flex;flex-direction:column;gap:12px;color:#5b6b7c;font-size:14px}
.check{
  display:inline-flex;width:20px;height:20px;border-radius:999px;
  align-items:center;justify-content:center;border:2px solid #ff5a1f;color:#ff5a1f;font-weight:800;
  margin-right:10px;transform:translateY(2px);
}
.cta{
  width:100%;height:56px;border:0;border-radius:14px;background:#ff5a1f;color:#fff;
  font-weight:800;font-size:16px;cursor:pointer;
  box-shadow:0 10px 26px rgba(255, 90, 31, 0.35);
}

/* ===== client view ===== */
.client .formWrap{
  position:absolute;
  top: 190px;
  left: 0;
  width: 100%;
  display:grid;
  grid-template-columns: 1fr;
  gap: 18px;
  justify-items:center;
}

/* form */
.formCard{
  width: 1000px;
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 20px 60px rgba(0,0,0,.35);
  padding: 26px;
  border: 1px solid rgba(0,0,0,0.06);
}

/* label + input style */
.lbl{display:block;margin-bottom:16px}
.lblRow{
  display:flex;align-items:center;gap:10px;
  font-weight:700;color:#2b3645;font-size:14px;margin-bottom:8px;
}
.ico{font-size:14px}
.lbl b{color:#ff5a1f}

input, select{
  width:100%;
  height:44px;
  border-radius:10px;
  border: 1px solid #d7dee8;
  padding: 0 14px;
  outline:none;
  font-size: 14px;
}
input:focus, select:focus{
  border-color:#ff5a1f;
  box-shadow: 0 0 0 3px rgba(255,90,31,0.12);
}

/* input with right icon */
.inputWithIcon{position:relative}
.rightIcon{
  position:absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color:#7b8aa0;
}

/* eye */
.eye{
  position:absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  border:0;
  background:transparent;
  cursor:pointer;
  font-size:16px;
}

/* address row with locate button */
.addrRow{
  display:grid;
  grid-template-columns: 1fr 150px;
  gap: 10px;
  align-items:center;
}
.locBtn{
  height:44px;
  border:0;
  border-radius:10px;
  background:#ff5a1f;
  color:#fff;
  font-weight:800;
  cursor:pointer;
}

/* terms */
.terms{
  background:#f7f9fc;
  border-radius:12px;
  padding: 14px;
  display:flex;
  gap: 10px;
  align-items:flex-start;
  margin-top: 6px;
}
.terms input{width:16px;height:16px;margin-top:2px}
.terms label{font-size:13px;color:#5b6b7c;line-height:1.4}
.link{color:#ff5a1f;font-weight:700}

/* submit */
.submit{
  margin-top: 16px;
  width:100%;
  height:56px;
  border:0;
  border-radius:12px;
  background:#ff5a1f;
  color:#fff;
  font-weight:900;
  font-size:16px;
  cursor:pointer;
  box-shadow: 0 10px 26px rgba(255, 90, 31, 0.35);
}

/* info card under form */
.whyCard{
  width: 1000px;
  background:#eaf3ff;
  border-radius: 14px;
  padding: 18px 20px;
  color:#2b3645;
}
.whyCard h3{margin:0 0 10px;font-size:16px}
.whyCard ul{margin:0;padding-left:0;list-style:none;display:flex;flex-direction:column;gap:10px;font-size:13px;color:#405066}
.dot{color:#ff5a1f;font-weight:900;margin-right:10px}
</style>
