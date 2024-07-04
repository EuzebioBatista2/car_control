<template>
  <div class="register-bg">
    <div class="title-auth">Registrar administrador</div>

    <form method="POST"
      :action="register" class="form-auth">

      <!-- Token -->
      <input type="hidden"
        name="_token"
        :value="token_csrf">

      <!-- Name -->
      <div class="row mb-3">
        <label for="name"
          class="col-md-4 col-form-label text-md-end">Nome:</label>

        <div class="col-md-6">
          <input id="name"
            type="text"
            :class="errors.name ? 'form-control is-invalid' : 'form-control'"
            name="name"
            placeholder="Insira seu nome..."
            v-model="old_name"
            :value="old_name"
            autocomplete="name"
            autofocus>

          <span v-if="errors.name"
            class="invalid-feedback"
            role="alert">
            <strong>{{ errors.name[0] }}</strong>
          </span>
        </div>
      </div>

      <!-- Lastname -->
      <div class="row mb-3">
        <label for="lastname"
          class="col-md-4 col-form-label text-md-end">Sobrenome:</label>

        <div class="col-md-6">
          <input id="lastname"
            type="text"
            :class="errors.lastname ? 'form-control is-invalid' : 'form-control'"
            name="lastname"
            placeholder="Insira seu sobrenome..."
            v-model="old_lastname"
            :value="old_lastname"
            autocomplete="lastname"
            autofocus>

          <span v-if="errors.lastname"
            class="invalid-feedback"
            role="alert">
            <strong>{{ errors.lastname[0] }}</strong>
          </span>
        </div>
      </div>

      <!-- Email -->
      <div class="row mb-3">
        <label for="email"
          class="col-md-4 col-form-label text-md-end">Email:</label>

        <div class="col-md-6">
          <input id="email"
            type="email"
            :class="errors.email ? 'form-control is-invalid' : 'form-control'"
            name="email"
            placeholder="Insira seu e-mail..."
            v-model="old_email"
            :value="old_email"
            autocomplete="email">

          <span v-if="errors.email"
            class="invalid-feedback"
            role="alert">
            <strong>{{ errors.email[0] }}</strong>
          </span>
        </div>
      </div>

      <!-- Password -->
      <div class="row mb-3">
        <label for="password"
          class="col-md-4 col-form-label text-md-end">Senha:</label>

        <div class="col-md-6 container-password">
          <input id="password"
            :type="pass_button === '' ? 'password' : 'text'"
            :class="errors.password ? 'form-control is-invalid' : 'form-control'"
            name="password"
            placeholder="Insira sua senha..."
            :value="old_password"
            v-model="old_password"
            autocomplete="password">
          <button type="button"
            class="password-eye-button eye-icon"
            @click.prevent="toggle_pass_button()">
            <i :class="`fa-solid fa-eye${pass_button}`"></i>
          </button>
        </div>
      </div>

      <!-- Confirm password -->
      <div class="row mb-3 ">
        <label for="password-confirm"
          class="col-md-4 col-form-label text-md-end">Confirmar senha:</label>

        <div class="col-md-6 container-password">
          <input id="password-confirm"
            :type="confirm_pass_button === '' ? 'password' : 'text'"
            :class="errors.password ? 'form-control is-invalid' : 'form-control'"
            name="password_confirmation"
            placeholder="Confirme sua senha..."
            v-model="old_confirm_password"
            :value="old_confirm_password"
            autocomplete="password_confirmation">
          <button type="button"
            class="confirm-password-eye-button eye-icon"
            @click.prevent="toggle_confirm_pass_button()">
            <i :class="`fa-solid fa-eye${confirm_pass_button}`"></i>
          </button>

          <span v-if="errors.password"
            class="invalid-feedback"
            role="alert">
            <strong>{{ errors.password[0] }}</strong>
          </span>
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit"
            class="btn btn-outline-danger">
            Registrar
          </button>
        </div>
      </div>
    </form>

    <div class="row">
      <div class="col-12 mt-4 information">
        <p>Já possui conta? <a :href="route_login">Clique aqui</a> para fazer o login.</p>
      </div>
    </div>

    <img src="/icons/user-solid.webp" alt="Icone de usuário" class="user-bg">
  </div>
</template>

<script>
export default {
  props: ['token_csrf', 'errors', 'old', 'register', 'route_login'],
  data() {
    return {
      /* Old */
      old_name: this.old.name ?? '',
      old_lastname: this.old.lastname ?? '',
      old_email: this.old.email ?? '',
      old_password: this.old.password ?? '',
      old_confirm_password: this.old.confirm_password ?? '',

      /* Button eye */
      pass_button: '',
      confirm_pass_button: ''
    }
  },
  methods: {
    toggle_pass_button() {
      this.pass_button === '' ? this.pass_button = '-slash' : this.pass_button = '';
    },

    toggle_confirm_pass_button() {
      this.confirm_pass_button === '' ? this.confirm_pass_button = '-slash' : this.confirm_pass_button = '';
    }
  }
}
</script>
<style scoped>
/* Container */
.register-bg {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: relative;
  min-height: 90vh;
  width: 100%;
  overflow: hidden;
  padding: 36px 12px;
}

.title-auth {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 30px;
}

.form-auth {
  padding: 0px 4px;
  width: 100%;
  z-index: 20;
}

.information {
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 20;
  text-align: center;
  word-break: break-word;
}

.information p {
  margin: 0;
}

.container-password {
  position: relative;
}

.user-bg {
  position: absolute;
  left: -60px;
  bottom: -50px;
  height: 260px;
  width: auto;
  filter: invert(100%);
  opacity: .2;
}

.eye-icon {
  display: inline-flex;
  position: absolute;
  right: 50px;
  top: 10px;
  font-size: 18px;
}

.fa-eye-slash {
  position: absolute;
  right: -1px;
}
</style>
