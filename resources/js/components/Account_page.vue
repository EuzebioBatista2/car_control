<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-user mx-2"></i> DADOS DA CONTA</h2>
      </div>
    </div>
    <div class="row"
      id="edit-container">
      <div class="col-12 black-container">
        <div class="inputs">
          <div class="container-sub-title mb-5">
            <h4>Editar dados <i class="fa-solid fa-pen-to-square mx-2"></i></h4>
          </div>
          <div class="form-container">
            <div class="item-container">
              <form :action="informations"
                method="POST">
                <!-- Token -->
                <input type="hidden"
                  name="_token"
                  :value="csrf_token">

                <!-- Put method -->
                <input type="hidden"
                  name="_method"
                  value="PUT">

                <!-- Name -->
                <div class="mb-3">
                  <div class="d-flex w-100 justify-content-start">
                    <label for="name"
                      class="form-label d-inline-flex mx-2 mb-1">Nome:</label>
                  </div>
                  <input type="text"
                    :class="errors.name ? 'form-control is-invalid' : 'form-control'"
                    id="name"
                    v-model="old_name"
                    :value="old_name"
                    name="name"
                    placeholder="Insira o nome do cliente...">
                  <span v-if="errors.name"
                    class="invalid-feedback"
                    role="alert">
                    <strong>{{ errors.name[0] }}</strong>
                  </span>
                </div>

                <!-- Lastname -->
                <div class="mb-3">
                  <div class="d-flex w-100 justify-content-start">
                    <label for="lastname"
                      class="form-label d-inline-flex mx-2 mb-1">Sobrenome:</label>
                  </div>
                  <input type="text"
                    :class="errors.lastname ? 'form-control is-invalid' : 'form-control'"
                    id="lastname"
                    name="lastname"
                    v-model="old_lastname"
                    :value="old_lastname"
                    placeholder="Insira o sobrenome do cliente...">
                  <span v-if="errors.lastname"
                    class="invalid-feedback"
                    role="alert">
                    <strong>{{ errors.lastname[0] }}</strong>
                  </span>
                </div>

                <!-- Email -->
                <div class="mb-3">
                  <div class="d-flex w-100 justify-content-start">
                    <label for="email"
                      class="form-label d-inline-flex mx-2 mb-1">Email:</label>
                  </div>
                  <input type="email"
                    :class="errors.email ? 'form-control is-invalid' : 'form-control'"
                    id="email"
                    name="email"
                    v-model="old_email"
                    :value="old_email"
                    placeholder="Insira o email do cliente...">
                  <span v-if="errors.email"
                    class="invalid-feedback"
                    role="alert">
                    <strong>{{ errors.email[0] }}</strong>
                  </span>
                </div>

                <div class="button-container">
                  <a :href="route"
                    class="btn btn-secondary">Voltar</a>
                  <button class="btn btn-primary"
                    type="submit">Atualizar dados</button>
                </div>

              </form>

            </div>

            <div class="item-container">
              <form :action="password"
                method="POST">
                <!-- Token -->
                <input type="hidden"
                  name="_token"
                  :value="csrf_token">

                <!-- Put method -->
                <input type="hidden"
                  name="_method"
                  value="PUT">

                <!-- Password -->
                <div class="mb-3">
                  <label for="current-password"
                    class="form-label d-inline-flex mx-2 mb-1">Senha Atual:</label>

                  <div class="container-password">
                    <input id="current-password"
                      :type="pass_button === '' ? 'password' : 'text'"
                      :class="errors.current_password ? 'form-control is-invalid' : 'form-control'"
                      name="current_password"
                      placeholder="Insira sua senha atual..."
                      :v-model="old_current_password"
                      autocomplete="password">
                    <button type="button"
                      class="password-eye-button eye-icon"
                      @click.prevent="toggle_pass_button()">
                      <i :class="`fa-solid fa-eye${pass_button}`"></i>
                    </button>
                    <span v-if="errors.current_password"
                      class="invalid-feedback"
                      role="alert">
                      <strong>{{ errors.current_password[0] }}</strong>
                    </span>
                  </div>
                </div>

                <!-- New password -->
                <div class="mb-3">
                  <label for="new-password"
                    class="form-label d-inline-flex mx-2 mb-1">Nova senha:</label>

                  <div class="container-password">
                    <input id="new-password"
                      :type="new_pass_button === '' ? 'password' : 'text'"
                      :class="errors.password ? 'form-control is-invalid' : 'form-control'"
                      name="password"
                      placeholder="Insira sua nova senha..."
                      :v-model="old_new_password"
                      autocomplete="password">
                    <button type="button"
                      class="password-eye-button eye-icon"
                      @click.prevent="toggle_new_pass_button()">
                      <i :class="`fa-solid fa-eye${new_pass_button}`"></i>
                    </button>
                  </div>
                </div>

                <!-- Confirm new password -->
                <div class="mb-3">
                  <label for="confirm-new-password"
                    class="form-label d-inline-flex mx-2 mb-1">Confirmar nova senha:</label>

                  <div class="container-password">
                    <input id="confirm-new-password"
                      :type="confirm_new_pass_button === '' ? 'password' : 'text'"
                      :class="errors.password ? 'form-control is-invalid' : 'form-control'"
                      name="password_confirmation"
                      placeholder="Confirme sua nova senha..."
                      :v-model="old_confirm_new_password"
                      autocomplete="password">
                    <button type="button"
                      class="password-eye-button eye-icon"
                      @click.prevent="toggle_confirm_new_pass_button()">
                      <i :class="`fa-solid fa-eye${confirm_new_pass_button}`"></i>
                    </button>
                    <span v-if="errors.password"
                      class="invalid-feedback"
                      role="alert">
                      <strong>{{ errors.password[0] }}</strong>
                    </span>
                  </div>
                </div>

                <div class="button-container">
                  <a :href="route"
                    class="btn btn-secondary">Voltar</a>
                  <button class="btn btn-primary"
                    type="submit">Atualizar senha</button>
                </div>
              </form>
            </div>
          </div>
          <div class="container-delete mt-5">
            <form :action="delete"
              method="POST"
              onsubmit="return confirm('Tem certeza que deseja excluir essa conta? Todos os dados cadastrados serão perdidos.');">
              <input type="hidden"
                name="_token"
                :value="csrf_token">

              <!-- Delete method -->
              <input type="hidden"
                name="_method"
                value="DELETE">
              <button type="submit"
                class="btn btn-danger mx-1">
                Deletar conta <i class="fa-solid fa-trash ms-2">
                </i></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ['csrf_token', 'errors', 'old', 'route', 'account', 'informations', 'password', 'delete'],
  data() {
    return {
      old_name: this.old.name ?? this.account.name ?? '',
      old_lastname: this.old.lastname ?? this.account.lastname ?? '',
      old_email: this.old.email ?? this.account.email ?? '',
      old_current_password: '',
      old_new_password: '',
      old_confirm_new_password: '',

      /* Button eye */
      pass_button: '',
      new_pass_button: '',
      confirm_new_pass_button: '',
    }
  },
  methods: {
    toggle_pass_button() {
      this.pass_button === '' ? this.pass_button = '-slash' : this.pass_button = '';
    },

    toggle_new_pass_button() {
      this.new_pass_button === '' ? this.new_pass_button = '-slash' : this.new_pass_button = '';
    },

    toggle_confirm_new_pass_button() {
      this.confirm_new_pass_button === '' ? this.confirm_new_pass_button = '-slash' : this.confirm_new_pass_button = '';
    }
  },
  mounted() {

  }

}
</script>
<style scoped>
/* Container */
.container {
  display: flex;
  flex-direction: column;
}

#container-title {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 40px 0px 20px 0px;
}

h2 {
  margin: 0px;
}

#edit-container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 1;
  margin: 10px 0px 30px 0px;
  border-radius: 8px;
}

.inputs {
  padding: 16px;
  color: white;
  background-color: #212529;
  border-radius: 8px;
}

.container-sub-title {
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  margin: 10px 0px 30px;
}

.container-delete {
  display: flex;
  align-items: center;
  justify-content: end;
  position: relative;
  margin: 10px 0px 10px;
}

.icon-back {
  display: inline-flex;
  position: absolute;
  left: 0;
  font-size: 24px;
  text-decoration: none;
  color: white;
}

h4 {
  margin: 0;
}

.form-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 20px;
}

.item-container {
  flex-grow: 1;
}

/* Password */
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

.button-container {
  display: flex;
  gap: 10px;
  justify-content: end;
}

/* Media */
@media (max-width: 576px) {
  .container {
    padding: 0px;
  }

  .black-container {
    padding: 0px;
  }
}
</style>
