<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-user"></i> CLIENTES</h2>
      </div>
    </div>
    <div class="row"
      id="table-container">
      <div class="col-12"
        id="container-card">
        <div class="card text-center h-100 bg-dark">
          <div class="card-header links-header">
            <div class="link-header">
              <nav>
                <form class="d-flex search-form"
                  role="search"
                  :action="route + '/search/'"
                  method="GET">
                  <!-- Search -->
                  <select class="form-select"
                    id="select"
                    name="select">
                    <option v-for="(column, key) in columns"
                      :value="key"
                      :selected="old_select === key">{{ column }}</option>
                  </select>
                  <input type="search"
                    name="data"
                    class="form-control"
                    v-model="old_data">
                  <button class="btn btn-outline-danger"
                    type="submit">Pesquisar</button>
                </form>
              </nav>
            </div>
            <div class="link-header add-button">
              <!-- Button modal -->
              <button class="btn btn-outline-danger"
                data-bs-toggle="modal"
                data-bs-target="#add-modal"
                id="modal-button">Adicionar cliente</button>
            </div>

            <!-- Modal -->
            <div class="modal fade"
              id="add-modal"
              data-bs-backdrop="static"
              data-bs-keyboard="false"
              tabindex="-1"
              aria-labelledby="staticBackdropLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2 class="modal-title fs-5"
                      id="staticBackdropLabel">Adicionar cliente</h2>
                    <button type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form :action="route"
                      method="POST">
                      <!-- Post method -->
                      <input type="hidden"
                        name="_token"
                        :value="csrf_token">

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

                      <!-- Phone number -->
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

                      <!-- Age -->
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

                      <!-- Gender -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="gender"
                            class="form-label d-inline-flex mx-2 mb-1">Gênero:</label>
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
                      <div class="modal-footer">
                        <button type="button"
                          class="btn btn-secondary"
                          data-bs-dismiss="modal">Fechar</button>
                        <button type="submit"
                          class="btn btn-primary">Criar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body table-over">
            <table v-if="customers.data && Object.keys(customers.data).length > 0"
              class="table table-dark table-striped table-hover">
              <thead>
                <tr>
                  <!-- Table columns -->
                  <th v-for="column in columns"
                    scope="col">{{ column }}</th>
                  <th scope="col">Opções</th>
                  <th scope="col">Adicionar</th>
                </tr>
              </thead>
              <tbody>
                <!-- Table data -->
                <tr v-for="customer in customers.data">
                  <th v-for="data in customer"
                    scope="row">
                    <span v-if="data === 'M'"
                      class="data text-primary"><i class="fa-solid fa-mars"></i></span>
                    <span v-else-if="data === 'F'"
                      class="data text-danger"><i class="fa-solid fa-venus"></i></span>
                    <span v-else-if="data === 'N'"
                      class="data text-warning"><i class="fa-solid fa-transgender"></i></span>
                    <span v-else
                      class="data">{{ data }}</span>
                  </th>
                  <th>
                    <a :href="route + '/' + customer.id" id="button-edit"
                      class="btn btn-warning mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form :action="route + '/' + customer.id"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                      <!-- Token -->
                      <input type="hidden"
                        name="_token"
                        :value="csrf_token">

                      <!-- Delete method -->
                      <input type="hidden"
                        name="_method"
                        value="DELETE">
                      <button type="submit" id="button-delete"
                        class="btn btn-danger mx-1">
                        <i class="fa-solid fa-trash">
                        </i></button>
                    </form>
                  </th>
                  <th><a :href="route_vehicle + '/' + customer.id" id="vehicle-button"
                      class="btn btn-primary">Veículos</a></th>
                </tr>
              </tbody>
            </table>
            <p v-else
              class="text-white">Não há dados cadastrados no momento ou informações não encontradas.</p>
          </div>
          <!-- Paginate -->
          <div v-if="customers.data && Object.keys(customers.data).length > 0"
            class="card-footer text-body-secondary container-footer">
            <nav aria-label="Page navigation" class="nav-page">
              <ul class="pagination">
                <li v-for="page in customers.links"
                  :key="page"
                  class="page-item">
                  <a v-if="page.label === 'pagination.previous'" class="page-link bg-dark text-white"
                    :href="page.url"
                    aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                  <a v-else-if="page.label === 'pagination.next'" class="page-link bg-dark text-white"
                    :href="page.url"
                    aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                  <a v-else class="page-link bg-dark text-white"
                    :class="page.active ? 'navigation-active' : ''"
                    :href="page.url">{{ page.label }}</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
/* Phone input */
import Inputmask from 'inputmask';

export default {
  props: ['customers', 'columns', 'csrf_token', 'errors', 'old', 'route', 'data', 'select', 'route_vehicle'],
  data() {
    return {
      old_name: this.old.name ?? '',
      old_lastname: this.old.lastname ?? '',
      old_email: this.old.email ?? '',
      old_phone: this.old.phone ?? '',
      old_age: this.old.age ?? '',
      old_gender: this.old.gender ? this.old.gender : 'N',
      old_data: this.data ?? '',
      old_select: this.select === '' ? 'id' : this.select
    }
  },
  mounted() {
    /* Are there data filled out in the modal? */
    if (Object.values(this.old).length > 0) {
      document.getElementById('modal-button').click();
    }

    Inputmask({
      mask: ['(99) 9999-9999', '(99) 99999-9999'],
      showMaskOnHover: true,
    }).mask(this.$refs.phone);
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

.search-form {
  flex-wrap: wrap;
  gap: 10px;
}

.search-form input {
  width: 50%;
}

.search-form button {
  width: 25%;
}

.search-form select {
  width: 20%;
}

/* Table */
#table-container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 1;
  margin: 10px 0px 30px 0px;
  border-radius: 8px;
  background-color: #212529;
}

#container-card {
  height: 100%;
  padding: 0;
}

.links-header {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 10px;
}

.link-header {
  flex-grow: 1;
}

.link-header nav {
  width: 500px;
}

.add-button {
  display: flex;
  justify-content: end;
}

.nav-page {
  overflow-x: auto;
}

.container-footer {
  display: flex;
  width: 100%;
  align-items: center;
  justify-content: center;
}

.table-over {
  overflow-x: scroll;
}

.table-over table {
  min-width: 1000px;
}

/* Modal */
#modal-container {
  display: flex;
  flex-direction: column;
  justify-content: start;
}

.navigation-active {
  z-index: 3;
  outline: 3px solid rgba(255, 0, 0, 0.418);
}

.data {
  display: flow;
  padding: inherit;
}

/* Media */
@media(max-width: 767px) {
  .add-button button {
    width: 100%;
  }

  .link-header nav {
    width: 100%;
  }

  .container {
    padding: 0px;
  }

  .search-form button {
    width: 100%;
  }

  .search-form select {
    width: 100%;
  }

  .search-form input {
    width: 100%;
  }
}
</style>
