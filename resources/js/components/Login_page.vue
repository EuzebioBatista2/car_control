<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-bg">
          <div class="card-header text-white">Login administrador</div>

          <div class="card-body">
            <form method="POST"
              :action="login">
              <input type="hidden"
                name="_token"
                :value="token_csrf">

              <div class="row mb-3">
                <label for="email"
                  class="col-md-4 col-form-label text-md-end text-white">E-mail</label>

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

              <div class="row mb-3">
                <label for="password"
                  class="col-md-4 col-form-label text-md-end text-white">Senha</label>

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
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['token_csrf', 'errors', 'old', 'login'],
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
.card-bg {
  background: linear-gradient(to right, rgb(0, 0, 0), rgb(67, 67, 67));
}

.container-password {
  position: relative;
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
