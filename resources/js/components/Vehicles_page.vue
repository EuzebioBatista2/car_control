<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-car"></i> VEÍCULOS</h2>
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
                <form class="d-flex"
                  role="search"
                  :action="route + '/search/'"
                  method="GET">
                  <input :class="'form-control me-2'"
                    type="search"
                    name="name"
                    placeholder="Consulte pelo nome do cliente"
                    v-model="old_search"
                    :value="old_search"
                    aria-label="Search">
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
                id="modal-button">Adicionar veículo</button>
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
                      id="staticBackdropLabel">Adicionar veículo</h2>
                    <button type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form :action="route"
                      method="POST">
                      <input type="hidden"
                        name="_token"
                        :value="csrf_token">
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="brand"
                            class="form-label d-inline-flex mx-2 mb-1">Marca:</label>
                        </div>
                        <select class="form-select"
                          :class="errors.brand ? 'form-control is-invalid' : 'form-control'"
                          id="brand"
                          name="brand">
                          <option value=""
                            :selected="old_brand === '' || old_brand">Selecione</option>
                          <option value="Fiat"
                            :selected="old_brand === 'Fiat'">Fiat</option>
                          <option value="Ford"
                            :selected="old_brand === 'Ford'">Ford</option>
                          <option value="Chevrolet"
                            :selected="old_brand === 'Chevrolet'">Chevrolet</option>
                        </select>
                        <span v-if="errors.brand"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.brand[0] }}</strong>
                        </span>
                      </div>

                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="model"
                            class="form-label d-inline-flex mx-2 mb-1">Modelo:</label>
                        </div>
                        <select class="form-select"
                          :class="errors.model ? 'form-control is-invalid' : 'form-control'"
                          id="model"
                          name="model">
                          <option value=""
                            :selected="old_model === '' || old_model">Selecione</option>
                          <option value="modelo1"
                            :selected="old_model === 'modelo1'">modelo1</option>
                          <option value="modelo2"
                            :selected="old_model === 'modelo2'">modelo2</option>
                          <option value="modelo3"
                            :selected="old_model === 'modelo3'">modelo3</option>
                        </select>
                        <span v-if="errors.model"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.model[0] }}</strong>
                        </span>
                      </div>

                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="year"
                            class="form-label d-inline-flex mx-2 mb-1">Ano:</label>
                        </div>
                        <input type="number"
                          :class="errors.year ? 'form-control is-invalid' : 'form-control'"
                          id="year"
                          name="year"
                          v-model="old_year"
                          :value="'2024'"
                          min="1950"
                          max="2024"
                          step="1"
                          placeholder="Insira a idade do cliente...">
                        <span v-if="errors.year"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.year[0] }}</strong>
                        </span>
                      </div>

                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="color"
                            class="form-label d-inline-flex mx-2 mb-1">Cor:</label>
                        </div>
                        <select class="form-select"
                          :class="errors.color ? 'form-control is-invalid' : 'form-control'"
                          id="color"
                          name="color">
                          <option value=""
                            :selected="old_color === '' || old_color">Selecione</option>
                          <option value="coloro1"
                            :selected="old_color === 'coloro1'">Branco</option>
                          <option value="coloro2"
                            :selected="old_color === 'coloro2'">Preto</option>
                          <option value="coloro3"
                            :selected="old_color === 'coloro3'">Prata</option>
                        </select>
                        <span v-if="errors.color"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.color[0] }}</strong>
                        </span>
                      </div>

                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="steering_system"
                            class="form-label d-inline-flex mx-2 mb-1">Sistema de direção:</label>
                        </div>
                        <div class="form-check d-flex w-100 justify-content-start gap-2 ms-2 mb-1">
                          <input class="form-check-input"
                            type="radio"
                            name="steering_system"
                            id="steering_system_1">
                          <label class="form-check-label"
                            for="steering_system_1">
                            Direção Hidráulica
                          </label>
                        </div>
                        <div class="form-check d-flex w-100 justify-content-start gap-2 ms-2 mb-1">
                          <input class="form-check-input"
                            type="radio"
                            name="steering_system"
                            id="steering_system_2">
                          <label class="form-check-label"
                            for="steering_system_2">
                            Direção Elétrica
                          </label>
                        </div>
                        <div class="form-check d-flex w-100 justify-content-start gap-2 ms-2 mb-1">
                          <input class="form-check-input"
                            type="radio"
                            name="steering_system"
                            id="steering_system_3">
                          <label class="form-check-label"
                            for="steering_system_3">
                            Direção Mecânica
                          </label>
                        </div>
                        <span v-if="errors.steering_system"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.steering_system[0] }}</strong>
                        </span>
                      </div>

                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="type_of_fuel"
                            class="form-label d-inline-flex mx-2 mb-1">Tipo de combustível:</label>
                        </div>
                        <div class="form-check d-flex w-100 justify-content-start gap-2 ms-2 mb-1">
                          <input class="form-check-input"
                            type="radio"
                            name="type_of_fuel"
                            id="type_of_fuel_1">
                          <label class="form-check-label"
                            for="type_of_fuel_1">
                            Gasolina
                          </label>
                        </div>
                        <div class="form-check d-flex w-100 justify-content-start gap-2 ms-2 mb-1">
                          <input class="form-check-input"
                            type="radio"
                            name="type_of_fuel"
                            id="type_of_fuel_2">
                          <label class="form-check-label"
                            for="type_of_fuel_2">
                            Diesel
                          </label>
                        </div>
                        <div class="form-check d-flex w-100 justify-content-start gap-2 ms-2 mb-1">
                          <input class="form-check-input"
                            type="radio"
                            name="type_of_fuel"
                            id="type_of_fuel_3">
                          <label class="form-check-label"
                            for="type_of_fuel_3">
                            Etanol (Álcool)
                          </label>
                        </div>
                        <span v-if="errors.type_of_fuel"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.type_of_fuel[0] }}</strong>
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
                  <th v-for="column in columns"
                    scope="col">{{ column }}</th>
                  <th scope="col">Veículos</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="vehicle in vehicles.data">
                  <th v-for="data in vehicle"
                    scope="row">
                    <span class="data">{{ data }}</span>
                  </th>
                  <th>
                    <a :href="route + '/' + vehicle.id"
                      class="btn btn-warning mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form :action="route + '/' + vehicle.id"
                      method="POST"
                      class="d-inline">
                      <input type="hidden"
                        name="_token"
                        :value="csrf_token">
                      <input type="hidden"
                        name="_method"
                        value="DELETE">
                      <button type="submit"
                        class="btn btn-danger mx-1">
                        <i class="fa-solid fa-trash">
                        </i></button>
                    </form>
                  </th>
                  <th><button class="btn btn-primary">Veículos</button></th>
                </tr>
              </tbody>
            </table>
            <p v-else
              class="text-white">Não há dados cadastrados no momento ou informações não encontradas.</p>
          </div>
          <div v-if="columns && columns.length > 0"
            class="card-footer text-body-secondary container-footer">
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link bg-dark text-white"
                    :href="vehicles.first_page_url"
                    aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
                <li v-for="page in vehicles.last_page"
                  :key="page"
                  class="page-item">
                  <a class="page-link bg-dark text-white"
                    :class="vehicles.links[page].active ? 'navigation-active' : ''"
                    :href="vehicles.path + '?page=' + page">{{ page }}</a>
                </li>
                <li class="page-item">
                  <a class="page-link bg-dark text-white"
                    :href="vehicles.next_page_url"
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
  props: ['vihecles', 'columns', 'csrf_token', 'errors', 'old', 'route', 'search'],
  data() {
    return {
      old_brand: this.old.brand ?? '',
      old_model: this.old.model ?? '',
      old_year: this.old.year ?? '',
      old_color: this.old.color ?? '',
      old_steering_system: this.old.steering_system ?? '',
      old_type_of_fuel: this.old.type_of_fuel ?? '',
      old_search: this.search ?? '',
    }
  },
  mounted() {
    if (Object.values(this.old).length > 0) {
      document.getElementById('modal-button').click();
    }
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

#table-container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 1;
  background-color: red;
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
  width: 400px;
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
}
</style>
