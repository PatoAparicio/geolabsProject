<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script src="https://unpkg.com/vue@3/dist/vue.global.js?v=1"></script>
</head>
<body>
    <div id="app">
    <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow">
          <div class="card-header bg-primary text-white p-0">
            <ul class="nav nav-tabs nav-tabs-custom" id="authTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link"  :class="{ active: activeTab === 'login' }" @click="activeTab = 'login'" type="button" >
                  Iniciar Sesión
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" :class="{ active: activeTab === 'register' }" @click="activeTab = 'register'" type="button" >
                  Registrarse
                </button>
              </li>
            </ul>
          </div>

          <div class="card-body">
            <div class="tab-content">
              <div v-show="activeTab === 'login'" class="tab-pane fade" :class="{ 'show active': activeTab === 'login' }">
                <form @submit.prevent="submitLogin" novalidate>
                  <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email *</label>
                    <input type="email" class="form-control" :class="{ 'is-invalid': loginErrors.email }" id="loginEmail" v-model="loginForm.email" placeholder="Ingrese su email" />
                    <div v-if="loginErrors.email" class="invalid-feedback">
                      @{{ loginErrors.email }}
                    </div>
                  </div>
                  
                  <div class="mb-3">
                    <label for="loginPassword" class="form-label">Contraseña *</label>
                    <input type="password" class="form-control" :class="{ 'is-invalid': loginErrors.password }" id="loginPassword" v-model="loginForm.password" placeholder="Ingrese su contraseña" />
                      <div v-if="loginErrors.password" class="invalid-feedback">
                      @{{ loginErrors.password }}
                    </div>
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary" :disabled="isLoginLoading">
                      <span v-if="isLoginLoading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                      @{{ isLoginLoading ? 'Iniciando sesión...' : 'Iniciar sesión' }}
                    </button>
                  </div>
                </form>
              </div>

              <div v-show="activeTab === 'register'" class="tab-pane fade" :class="{ 'show active': activeTab === 'register' }">
                <form @submit.prevent="submitRegister" novalidate>
                  <div class="mb-3">
                    <label for="registerName" class="form-label">Nombre *</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid': registerErrors.name }" id="registerName" v-model="registerForm.name" placeholder="Ingrese su nombre" />
                    <div v-if="registerErrors.name" class="invalid-feedback">
                      @{{ registerErrors.name }}
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="registerLastName" class="form-label">Apellido *</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid': registerErrors.last_name }" id="registerLastName" v-model="registerForm.last_name" placeholder="Ingrese su apellido" />
                    <div v-if="registerErrors.last_name" class="invalid-feedback">
                      @{{ registerErrors.last_name }}
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="registerEmail" class="form-label">Email *</label>
                    <input type="email" class="form-control" :class="{ 'is-invalid': registerErrors.email }" id="registerEmail" v-model="registerForm.email" placeholder="ejemplo@correo.com" />
                    <div v-if="registerErrors.email" class="invalid-feedback">
                      @{{ registerErrors.email }}
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="registerPassword" class="form-label">Contraseña *</label>
                    <input type="password" class="form-control" :class="{ 'is-invalid': registerErrors.password }" id="registerPassword" v-model="registerForm.password" placeholder="Mínimo 8 caracteres" />
                    <div v-if="registerErrors.password" class="invalid-feedback">
                      @{{ registerErrors.password }}
                    </div>
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary" :disabled="isRegisterLoading">
                      <span v-if="isRegisterLoading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                      @{{ isRegisterLoading ? 'Registrando...' : 'Registrar' }}
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div v-if="message" class="mt-3">
              <div class="alert" :class="message.type === 'success' ? 'alert-success' : 'alert-danger'" role="alert">
                <strong>@{{ message.type === 'success' ? 'Éxito!' : 'Error!' }}</strong>
                @{{ message.text }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const { createApp, ref, reactive } = Vue;

const app = createApp({
  setup() {
    const activeTab = ref('login');
    const isLoginLoading = ref(false);
    const isRegisterLoading = ref(false);
    const message = ref(null);

    const loginForm = reactive({
      email: '',
      password: ''
    });

    const registerForm = reactive({
      name: '',
      last_name: '',
      email: '',
      password: ''
    });

    const loginErrors = reactive({
      email: '',
      password: ''
    });

    const registerErrors = reactive({
      name: '',
      last_name: '',
      email: '',
      password: ''
    });

    const validateEmail = (email) => {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    };

    const validateLogin = () => {
      let isValid = true;
      
      Object.keys(loginErrors).forEach(key => {
        loginErrors[key] = '';
      });

      if (!loginForm.email) {
        loginErrors.email = 'El email es requerido';
        isValid = false;
      } else if (!validateEmail(loginForm.email)) {
        loginErrors.email = 'El email no es válido';
        isValid = false;
      }

      if (!loginForm.password) {
        loginErrors.password = 'La contraseña es requerida';
        isValid = false;
      } else if (loginForm.password.length < 6) {
        loginErrors.password = 'La contraseña debe tener al menos 6 caracteres';
        isValid = false;
      }

      return isValid;
    };

    const validateRegister = () => {
      let isValid = true;
      
      Object.keys(registerErrors).forEach(key => {
        registerErrors[key] = '';
      });

      if (!registerForm.name) {
        registerErrors.name = 'El nombre es requerido';
        isValid = false;
      }

      if (!registerForm.last_name) {
        registerErrors.last_name = 'El apellido es requerido';
        isValid = false;
      }

      if (!registerForm.email) {
        registerErrors.email = 'El email es requerido';
        isValid = false;
      } else if (!validateEmail(registerForm.email)) {
        registerErrors.email = 'El email no es válido';
        isValid = false;
      }

      if (!registerForm.password) {
        registerErrors.password = 'La contraseña es requerida';
        isValid = false;
      } else if (registerForm.password.length < 8) {
        registerErrors.password = 'La contraseña debe tener al menos 8 caracteres';
        isValid = false;
      }

      return isValid;
    };

    const showMessage = (type, text) => {
      message.value = { type, text };
      setTimeout(() => {
        message.value = null;
      }, 5000);
    };

    const submitLogin = async () => {
      if (!validateLogin()) return;

      isLoginLoading.value = true;
      try {
        const response = await fetch('/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(loginForm)
        });

        const data = await response.json();
        
        if (response.ok) {
          showMessage('success', 'Inicio de sesión exitoso');
          loginForm.email = '';
          loginForm.password = '';
           Object.keys(loginErrors).forEach(key => {
            loginErrors[key] = '';
          });

        } else {
          showMessage('error', 'Error en el inicio de sesión');
        }
      } catch (error) {
        showMessage('error', 'Error de conexión');
      } finally {
        isLoginLoading.value = false;
      }
    };

    const submitRegister = async () => {
      if (!validateRegister()) return;

      isRegisterLoading.value = true;
      try {
        const response = await fetch('/api/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(registerForm)
        });

        const data = await response.json();
        
        if (response.ok) {
          showMessage('success', 'Registro exitoso');
          Object.keys(registerForm).forEach(key => {
            registerForm[key] = '';
          });
          Object.keys(registerErrors).forEach(key => {
            registerErrors[key] = '';
          });
          activeTab.value = 'login';
        } else {
          showMessage('error', data.message || 'Error en el registro');
        }
      } catch (error) {
        showMessage('error', 'Error de conexión');
      } finally {
        isRegisterLoading.value = false;
      }
    };

    return {
      activeTab,
      isLoginLoading,
      isRegisterLoading,
      message,
      loginForm,
      registerForm,
      loginErrors,
      registerErrors,
      submitLogin,
      submitRegister
    };
  }
});

app.mount('#app');
</script>

</body>
</html> 

