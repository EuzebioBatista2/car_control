<template>
  <div class="login-bg">
    <div class="title-auth">Login do administrador</div>

    <form method="POST"
      :action="login" class="form-auth">

      <!-- Token -->
      <input type="hidden"
        name="_token"
        :value="token_csrf">

      <!-- Email -->
      <div class="row mb-3">
        <label for="email"
          class="col-md-4 col-form-label text-md-end">E-mail:</label>

        <div class="col-md-6">
          <input id="email"
            type="email"
            :class="errors.email ? 'form-control is-invalid' : 'form-control'"
            name="email"
            v-model="old_email"
            :value="old_email"
            autocomplete="email"
            placeholder="Insira seu e-mail..."
            autofocus>
        </div>
      </div>

      <!-- Password -->
      <div class="row mb-3">
        <label for="password"
          class="col-md-4 col-form-label text-md-end">Senha:</label>

        <div class="col-md-6 container-password">
          <input id="password"
            :type="pass_button === '' ? 'password' : 'text'"
            :class="errors.email ? 'form-control is-invalid' : 'form-control'"
            name="password"
            placeholder="Insira sua senha..."
            autocomplete="current-password">

          <button type="button"
            class="password-eye-button eye-icon"
            @click.prevent="toggle_pass_button()">
            <i :class="`fa-solid fa-eye${pass_button}`"></i>
          </button>

          <span v-if="errors.email"
            class="invalid-feedback"
            role="alert">
            <strong>Login ou senha inválidos</strong>
          </span>
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-8 offset-md-4">
          <button type="submit"
            class="btn btn-outline-danger">
            Logar
          </button>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="col-12 mt-4 information">
        <p>Ainda não criou sua conta? <a :href="route_register">Clique aqui</a></p>
      </div>
    </div>
    <img src="/icons/car-solid.webp" alt="Icone de carro" class="car-bg">
  </div>
</template>

<script>
export default {
  props: ['token_csrf', 'errors', 'old', 'login', 'route_register'],
  data() {
    return {
      /* Old */
      old_email: this.old.email ?? '',

      /* Button eye */
      pass_button: '',
    }
  },
  methods: {
    toggle_pass_button() {
      this.pass_button === '' ? this.pass_button = '-slash' : this.pass_button = '';
    },
  }
}
</script>
<style scoped>
/* Container */
.login-bg {
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

.car-bg {
  position: absolute;
  right: -60px;
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
