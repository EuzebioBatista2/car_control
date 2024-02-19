<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-bg">
          <div class="card-header text-white">Registrar</div>

          <div class="card-body">
            <form method="POST"
              :action="register">
              <input type="hidden"
                name="_token"
                :value="token_csrf">

              <div class="row mb-3">
                <label for="name"
                  class="col-md-4 col-form-label text-md-end text-white">Nome:</label>

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

              <div class="row mb-3">
                <label for="lastname"
                  class="col-md-4 col-form-label text-md-end text-white">Sobrenome:</label>

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

              <div class="row mb-3">
                <label for="email"
                  class="col-md-4 col-form-label text-md-end text-white">Email:</label>

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

              <div class="row mb-3">
                <label for="password"
                  class="col-md-4 col-form-label text-md-end text-white">Senha:</label>

                <div class="col-md-6 container-password">
                  <input id="password"
                    :type="pass_button === '' ? 'password' : 'text'"
                    :class="errors.password ? 'form-control is-invalid' : 'form-control'"
                    name="password"
                    placeholder="Insira sua senha..."
                    :value="old_password"
                    v-model="old_password"
                    autocomplete="new-password">
                  <button type="button"
                    class="password-eye-button eye-icon"
                    @click.prevent="toggle_pass_button()">
                    <i :class="`fa-solid fa-eye${pass_button}`"></i>
                  </button>
                </div>
              </div>

              <div class="row mb-3 ">
                <label for="password-confirm"
                  class="col-md-4 col-form-label text-md-end text-white">Confirmar senha:</label>

                <div class="col-md-6 container-password">
                  <input id="password-confirm"
                    :type="confirm_pass_button === '' ? 'password' : 'text'"
                    :class="errors.password ? 'form-control is-invalid' : 'form-control'"
                    name="password_confirmation"
                    placeholder="Confirme sua senha..."
                    v-model="old_confirm_password"
                    :value="old_confirm_password"
                    autocomplete="new-password">
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
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['token_csrf', 'errors', 'old', 'register'],
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
