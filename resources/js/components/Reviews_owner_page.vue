<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-address-book mx-2"></i> REVISÃO(ÕES) DO VEÍCULO</h2>
        <a :href="route"
          class="back-link"><i class="fa-solid fa-left-long"></i></a>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="inputs-container">
          <!-- User content -->
          <h4 class="w-100"><i class="fa-solid fa-user mx-2"></i> Dados do usuário/veículo</h4>
          <div class="input-items">

            <!-- Name -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="name"
                  class="form-label d-inline-flex mx-2 mb-1">Nome:</label>
              </div>
              <input type="text"
                class="form-control"
                id="name"
                :value="vehicle.name"
                readonly />
            </div>

            <!-- Lastname -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="lastname"
                  class="form-label d-inline-flex mx-2 mb-1">Sobrenome:</label>
              </div>
              <input type="text"
                class="form-control"
                id="lastname"
                :value="vehicle.lastname"
                readonly />
            </div>

            <!-- brand -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="brand"
                  class="form-label d-inline-flex mx-2 mb-1">Marca:</label>
              </div>
              <input type="text"
                class="form-control"
                id="brand"
                :value="vehicle.brand"
                readonly />
            </div>

            <!-- year -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="year"
                  class="form-label d-inline-flex mx-2 mb-1">Ano:</label>
              </div>
              <input type="integer"
                class="form-control"
                id="year"
                :value="vehicle.year"
                readonly />
            </div>

          </div>
          <div class="input-items">

            <!-- Email -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="email"
                  class="form-label d-inline-flex mx-2 mb-1">Email:</label>
              </div>
              <input type="email"
                class="form-control"
                id="email"
                :value="vehicle.email"
                readonly />
            </div>

            <!-- Phone -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="phone"
                  class="form-label d-inline-flex mx-2 mb-1">Telefone:</label>
              </div>
              <input type="text"
                class="form-control"
                id="phone"
                :value="vehicle.phone"
                readonly />
            </div>

            <!-- model -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="model"
                  class="form-label d-inline-flex mx-2 mb-1">Modelo:</label>
              </div>
              <input type="text"
                class="form-control"
                id="model"
                :value="vehicle.model"
                readonly />
            </div>

            <!-- color -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="color"
                  class="form-label d-inline-flex mx-2 mb-1">Cor:</label>
              </div>
              <input type="text"
                class="form-control"
                id="color"
                :value="vehicle.color"
                readonly />
            </div>
          </div>
        </div>
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
                <form class="search-container"
                  role="search"
                  :action="route + '/search_owner/' + vehicle.id"
                  method="GET">

                  <!-- Initial date -->
                  <input class="form-control search-item"
                    type="datetime-local"
                    name="initial_date"
                    id="initial_date"
                    aria-label="initial date">

                  <!-- Final date  -->
                  <input class="form-control search-item"
                    type="datetime-local"
                    name="final_date"
                    id="final_date"
                    aria-label="final date">
                  <button class="btn btn-outline-danger search-item"
                    type="submit">Pesquisar</button>
                </form>
              </nav>
            </div>
            <div class="link-header add-button">
              <!-- Button modal -->
              <button class="btn btn-outline-danger"
                data-bs-toggle="modal"
                data-bs-target="#add-modal"
                id="modal-button">Adicionar revisão</button>
            </div>

            <!-- Modal -->
            <div class="modal fade"
              id="add-modal"
              data-bs-backdrop="static"
              data-bs-keyboard="false"
              tabindex="-1"
              aria-labelledby="staticBackdropLabel"
              aria-hidden="false">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2 class="modal-title fs-5"
                      id="staticBackdropLabel">Adicionar revisão</h2>
                    <button type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      data-bs-target="#add-modal"
                      aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form :action="route + '/' + vehicle.id"
                      method="POST">

                      <!-- Token -->
                      <input type="hidden"
                        name="_token"
                        :value="csrf_token">

                      <!-- Vehicle ID -->
                      <input type="hidden"
                        name="vehicle_id"
                        :value="vehicle.id">

                      <!-- Name -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="name"
                            class="form-label d-inline-flex mx-2 mb-1">Nome:</label>
                        </div>
                        <input type="text"
                          class="form-control"
                          id="name"
                          :value="vehicle.name"
                          readonly />
                      </div>

                      <!-- Brand -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="brand"
                            class="form-label d-inline-flex mx-2 mb-1">Marca:</label>
                        </div>
                        <input type="text"
                          class="form-control"
                          id="brand"
                          :value="vehicle.brand"
                          readonly />
                      </div>

                      <!-- Model -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="model"
                            class="form-label d-inline-flex mx-2 mb-1">Modelo:</label>
                        </div>
                        <input type="text"
                          class="form-control"
                          id="model"
                          :value="vehicle.model"
                          readonly />
                      </div>

                      <!-- Year -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="year"
                            class="form-label d-inline-flex mx-2 mb-1">Ano:</label>
                        </div>
                        <input type="integer"
                          class="form-control"
                          id="year"
                          :value="vehicle.year"
                          readonly />
                      </div>

                      <!-- Color -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="color"
                            class="form-label d-inline-flex mx-2 mb-1">Cor:</label>
                        </div>
                        <input type="text"
                          class="form-control"
                          id="color"
                          :value="vehicle.color"
                          readonly />
                      </div>

                      <!-- Problems found -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="problems"
                            class="form-label d-inline-flex mx-2 mb-1">Problema(s) encontrado(s):</label>
                        </div>
                        <textarea :class="errors.problems ? 'form-control is-invalid' : 'form-control'"
                            placeholder="Informe os problemas encontrados"
                            id="problems"
                            name="problems"
                            style="height: 100px"></textarea>
                        <span v-if="errors.problems"
                          class="text-danger"
                          style="font-size: 0.875em; font-weight: bolder;">
                          <strong>{{ errors.problems[0] }}</strong>
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
            <table v-if="columns && columns.length > 0"
              class="table table-dark table-striped table-hover">
              <thead>
                <tr>
                  <!-- Table columns -->
                  <th v-for="column in columns"
                    scope="col" :style="column === 'Problemas' ? 'max-width: 400px;' : ''">
                    {{ column }}
                  </th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>
              <tbody>
                <!-- Table data -->
                <tr v-for="review in reviews.data">
                  <th v-for="data in review"
                    scope="row">
                    <span v-if="is_date(data)"
                      class="data">{{ format_date(data) }}</span>
                    <span v-else-if="data === '1'"
                      class="data">
                      <input type="checkbox"
                        class="form-check-input"
                        checked
                        disabled>
                    </span>
                    <span v-else-if="data === '0'"
                      class="data">
                      <input type="checkbox"
                        class="form-check-input"
                        disabled>
                    </span>
                    <span v-else
                      class="data" style="overflow-wrap: break-word; max-width: 400px;margin: 0px auto;">{{ data }}</span>
                  </th>
                  <th>
                    <a :href="route + '/' + vehicle.id + '/' + review.id"
                      class="btn btn-warning mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form :action="route + '/' + vehicle.id + '/' + review.id"
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
                      <button type="submit"
                        class="btn btn-danger mx-1">
                        <i class="fa-solid fa-trash">
                        </i></button>
                    </form>
                  </th>
                </tr>
              </tbody>
            </table>
            <p v-else
              class="text-white">Não há dados cadastrados no momento ou informações não encontradas.</p>
          </div>

          <!-- Paginate -->
          <div v-if="columns && columns.length > 0"
            class="card-footer text-body-secondary container-footer">
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link bg-dark text-white"
                    :href="reviews.first_page_url"
                    aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
                <li v-for="page in reviews.last_page"
                  :key="page"
                  class="page-item">
                  <a class="page-link bg-dark text-white"
                    :class="reviews.links[page].active ? 'navigation-active' : ''"
                    :href="reviews.path + '?page=' + page">{{ page }}</a>
                </li>
                <li class="page-item">
                  <a class="page-link bg-dark text-white"
                    :href="reviews.next_page_url"
                    aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
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

export default {
  props: ['reviews', 'vehicle', 'columns', 'csrf_token', 'errors', 'old', 'route', 'old_date', 'date'],
  data() {
    return {
      old_problems: this.old.problems ?? '',
    }
  },
  methods: {
    is_date(value) {
      return moment(value, 'YYYY-MM-DD HH:mm:ss', true).isValid();
    },
    format_date(date) {
      return moment(date).format('DD/MM/YYYY HH:mm:ss');
    }
  },
  mounted() {
    if (Object.values(this.old).length > 0) {
      document.getElementById('modal-button').click();
    }

    $('#final_date').val(this.date);
    $('#initial_date').val(this.old_date);
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
  justify-content: space-between;
}

.back-link {
  font-size: 28px;
  color: black;
  text-decoration: none;
}

h2 {
  margin: 0px;
}

.inputs-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 20px;
  padding: 16px;
  color: white;
  background-color: #212529;
  border-radius: 8px;
}

.input-items {
  flex-grow: 1;
}

/* Table */
#table-container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 1;
  margin: 10px 0px 30px 0px;
  border-radius: 8px;
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
  width: 100%;
}

.search-container {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  gap: 6px;
}

.search-item {
  width: 200px;
  min-width: 200px;
}
.add-button {
  display: flex;
  justify-content: end;
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
@media(max-width: 990px) {
  .add-button button {
    width: 100%;
  }

  .search-item {
    width: 100%;
  }

  .container {
    padding: 0px;
  }
}
</style>
