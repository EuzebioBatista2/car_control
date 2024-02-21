<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-user"></i> CLIENTES</h2>
      </div>
    </div>
    <div class="row"
      id="edit-container">
      <div class="col-12">
        <div class="container-sub-title">
          <h4>Editar dados <i class="fa-solid fa-pen-to-square"></i></h4>
          <a :href="route"
            class="icon-back"><i class="fa-solid fa-left-long"></i></a>
        </div>
      </div>
      <div class="col-12">
        <div class="inputs">
          <form :action="route + '/' + customer.id" method="POST"
            class="form-container">
            <input type="hidden"
              name="_token"
              :value="csrf_token">
            <input type="hidden"
              name="_method"
              value="PUT">
            <div class="item-container">
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

              <div class="mb-3">
                <div class="d-flex w-100 justify-content-start">
                  <label for="gender"
                    class="form-label d-inline-flex mx-2 mb-1">Sexo:</label>
                </div>
                <select class="form-select"
                  :class="errors.gender ? 'form-control is-invalid' : 'form-control'"
                  id="gender"
                  name="gender">
                  <option value="N"
                    :selected="old_gender === 'N' || old_gender">Não informar</option>
                  <option value="M"
                    :selected="old_gender === 'M'">Masculino</option>
                  <option value="F"
                    :selected="old_gender === 'F'">Feminino</option>
                </select>
                <span v-if="errors.gender"
                  class="invalid-feedback"
                  role="alert">
                  <strong>{{ errors.gender[0] }}</strong>
                </span>
              </div>

            </div>
            <div class="item-container">
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

              <div class="mb-3">
                <div class="d-flex w-100 justify-content-start">
                  <label for="phone"
                    class="form-label d-inline-flex mx-2 mb-1">Número de contato:</label>
                </div>
                <input type="text"
                  :class="errors.phone ? 'form-control is-invalid' : 'form-control'"
                  id="phone"
                  name="phone"
                  v-model="old_phone"
                  :value="old_phone"
                  minlength="14"
                  maxlength="15"
                  placeholder="Insira o n. de contato do cliente..."
                  ref="phone">
                <span v-if="errors.phone"
                  class="invalid-feedback"
                  role="alert">
                  <strong>{{ errors.phone[0] }}</strong>
                </span>
              </div>

              <div class="mb-3">
                <div class="d-flex w-100 justify-content-start">
                  <label for="age"
                    class="form-label d-inline-flex mx-2 mb-1">Idade:</label>
                </div>
                <input type="number"
                  :class="errors.age ? 'form-control is-invalid' : 'form-control'"
                  id="age"
                  name="age"
                  v-model="old_age"
                  :value="old_age"
                  min="1"
                  max="150"
                  placeholder="Insira a idade do cliente...">
                <span v-if="errors.age"
                  class="invalid-feedback"
                  role="alert">
                  <strong>{{ errors.age[0] }}</strong>
                </span>
              </div>

              <div class="button-container">
                <button type="reset"
                  class="btn btn-secondary">Cancelar</button>
                <button class="btn btn-primary"
                  type="submit">Atualizar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Inputmask from 'inputmask';

export default {
  props: ['customer', 'csrf_token', 'errors', 'old', 'route'],
  data() {
    return {
      old_name: this.customer.name,
      old_lastname: this.customer.lastname,
      old_email: this.customer.email,
      old_phone: this.customer.phone,
      old_age: this.customer.age,
      old_gender: this.customer.gender,
    }
  },
  mounted() {
    Inputmask({
      mask: ['(99) 9999-9999', '(99) 99999-9999'],
      showMaskOnHover: true,
    }).mask(this.$refs.phone);
  }

}
</script>
<style scoped>
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

.container-sub-title {
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  margin: 10px 0px 30px;
}

.icon-back {
  display: inline-flex;
  position: absolute;
  left: 0;
  font-size: 24px;
  text-decoration: none;
  color: black;
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

.button-container {
  display: flex;
  gap: 10px;
  justify-content: end;
}</style>
