<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-car mx-2"></i> PROPRIETÁRIO DOS VEÍCULOS</h2>
        <a :href="route"
          class="back-link"><i class="fa-solid fa-left-long"></i></a>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="inputs-container">
          <!-- User content -->
          <h4 class="w-100"><i class="fa-solid fa-user mx-2"></i> Dados do usuário</h4>
          <div class="input-items">
            <!-- Name -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="name"
                  class="form-label d-inline-flex mx-2 mb-1">Nome:</label>
              </div>
              <input type="text"
                :class="errors.name ? 'form-control is-invalid' : 'form-control'"
                id="name"
                :value="customer.name"
                readonly />
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
                :value="customer.lastname"
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
                :class="errors.email ? 'form-control is-invalid' : 'form-control'"
                id="email"
                :value="customer.email"
                readonly />
            </div>

            <!-- Phone -->
            <div class="mb-3">
              <div class="d-flex w-100 justify-content-start">
                <label for="phone"
                  class="form-label d-inline-flex mx-2 mb-1">Telefone:</label>
              </div>
              <input type="text"
                :class="errors.phone ? 'form-control is-invalid' : 'form-control'"
                id="phone"
                :value="customer.phone"
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
                <form class="d-flex search-form"
                  role="search"
                  :action="route + '/search_owner/' + customer.id"
                  method="GET">
                  <!-- Search -->
                  <select class="form-select search-form"
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
                id="modal-button">Adicionar veículo</button>
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
                      id="staticBackdropLabel">Adicionar veículo</h2>
                    <button type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      data-bs-target="#add-modal"
                      aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form :action="route + '/' + customer.id"
                      method="POST">
                      <!-- Token -->
                      <input type="hidden"
                        name="_token"
                        :value="csrf_token">

                      <!-- Plate -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="plate"
                            class="form-label d-inline-flex mx-2 mb-1">Placa:</label>
                        </div>
                        <input type="text"
                          :class="errors.plate ? 'form-control is-invalid' : 'form-control'"
                          id="plate"
                          v-model="old_plate"
                          :value="old_plate"
                          ref="plate"
                          name="plate"
                          maxlength="8"
                          autocomplete="off"
                          placeholder="Insira a placa do carro...">
                        <span v-if="errors.plate"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.plate[0] }}</strong>
                        </span>
                      </div>

                      <!-- Brand -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="brand"
                            class="form-label d-inline-flex mx-2 mb-1">Marca:</label>
                        </div>
                        <select :class="errors.brand ? 'form-select is-invalid' : 'form-select'"
                          id="brand"
                          name="brand"
                          ref="brand">
                          <option value=""
                            :selected="old_brand === '' || old_brand">Selecione</option>
                          <option v-for="brand in vehicles_data.brands"
                            :value="brand"
                            :selected="old_brand === brand">{{ brand }}</option>
                        </select>
                        <span v-if="errors.brand"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.brand[0] }}</strong>
                        </span>
                      </div>

                      <!-- Model -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="model"
                            class="form-label d-inline-flex mx-2 mb-1">Modelo:</label>
                        </div>
                        <select :class="errors.model ? 'form-select is-invalid' : 'form-select w-100'"
                          id="model"
                          name="model"
                          ref="model">
                          <option value=""
                            :selected="old_model === '' || old_model">Selecione</option>
                          <option v-for="model in models_data.models"
                            :value="model"
                            :selected="old_model === model">{{ model }}</option>
                        </select>
                        <span v-if="errors.model"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.model[0] }}</strong>
                        </span>
                      </div>

                      <!-- Year -->
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
                          :value="old_year"
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

                      <!-- Color -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="color"
                            class="form-label d-inline-flex mx-2 mb-1">Cor:</label>
                        </div>
                        <select :class="errors.color ? 'form-select is-invalid' : 'form-select'"
                          id="color"
                          name="color"
                          ref="color">
                          <option value=""
                            :selected="old_color === '' || old_color">Selecione</option>
                          <option v-for="color in vehicles_data.colors"
                            :value="color"
                            :selected="old_color === color">{{ color }}</option>
                        </select>
                        <span v-if="errors.color"
                          class="invalid-feedback"
                          role="alert">
                          <strong>{{ errors.color[0] }}</strong>
                        </span>
                      </div>

                      <!-- Steering system -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="steering_system"
                            class="form-label d-inline-flex mx-2 mb-2">Sistema de direção:</label>
                        </div>
                        <div v-for="steering_system in vehicles_data.steering_systems"
                          class="form-check d-flex w-100 justify-content-start gap-2 ms-2 mb-1">
                          <input :class="errors.steering_system ? 'form-check-input is-invalid' : 'form-check-input'"
                            type="radio"
                            name="steering_system"
                            :value="steering_system"
                            :id="steering_system"
                            :checked="old_steering_system === steering_system">
                          <label class="form-check-label"
                            :for="steering_system">
                            {{ steering_system }}
                          </label>
                        </div>
                        <span v-if="errors.steering_system"
                          class="text-danger"
                          style="font-size: 0.875em; font-weight: bolder;">
                          <strong>{{ errors.steering_system[0] }}</strong>
                        </span>
                      </div>

                      <!-- Type of fuel -->
                      <div class="mb-3">
                        <div class="d-flex w-100 justify-content-start">
                          <label for="type_of_fuel"
                            class="form-label d-inline-flex mx-2 mb-2">Tipo de combustível:</label>
                        </div>
                        <div v-for="type_of_fuel in vehicles_data.type_of_fuels"
                          class="form-check d-flex w-100 justify-content-start gap-2 ms-2 mb-1">
                          <input :class="errors.type_of_fuel ? 'form-check-input is-invalid' : 'form-check-input'"
                            type="radio"
                            name="type_of_fuel"
                            :value="type_of_fuel"
                            :id="type_of_fuel"
                            :checked="old_type_of_fuel === type_of_fuel">
                          <label class="form-check-label"
                            :for="type_of_fuel">
                            {{ type_of_fuel }}
                          </label>
                        </div>
                        <span v-if="errors.type_of_fuel"
                          class="text-danger"
                          style="font-size: 0.875em; font-weight: bolder;">
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
            <table v-if="vehicles.data && Object.keys(vehicles.data).length > 0"
              class="table table-dark table-striped table-hover">
              <thead>
                <tr>
                  <!-- Table columns -->
                  <th v-for="column in columns"
                    scope="col">
                    {{ column }}
                  </th>
                  <th scope="col">Ações</th>
                  <th scope="col">Revisões</th>
                </tr>
              </thead>
              <tbody>
                <!-- Table data -->
                <tr v-for="vehicle in vehicles.data">
                  <th v-for="data in vehicle"
                    scope="row">
                    <span class="data">{{ data }}</span>
                  </th>
                  <th>
                    <a :href="route + '/' + customer.id + '/' + vehicle.id" id="button-edit"
                      class="btn btn-warning mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form :action="route + '/' + customer.id + '/' + vehicle.id"
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
                        id="button-delete"
                        class="btn btn-danger mx-1">
                        <i class="fa-solid fa-trash">
                        </i></button>
                    </form>
                  </th>
                  <th><a :href="route_review + '/' + vehicle.id"
                      id="review-button"
                      class="btn btn-primary">Revisões</a></th>
                </tr>
              </tbody>
            </table>
            <p v-else
              class="text-white">Não há dados cadastrados no momento ou informações não encontradas.</p>
          </div>

          <!-- Paginate -->
          <div v-if="vehicles.data && Object.keys(vehicles.data).length > 0"
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
/* Plate input */
import Inputmask from 'inputmask';

export default {
  props: ['vehicles', 'customer', 'columns', 'csrf_token', 'errors', 'old', 'route', 'select', 'data', 'route_review', 'url_route'],
  data() {
    return {
      old_plate: this.old.plate ?? '',
      old_brand: this.old.brand ?? '',
      old_model: this.old.model ?? '',
      old_year: this.old.year ?? '2024',
      old_color: this.old.color ?? '',
      old_steering_system: this.old.steering_system ?? '',
      old_type_of_fuel: this.old.type_of_fuel ?? '',
      old_data: this.data ?? '',
      old_select: this.select === '' ? 'id' : this.select,
      vehicles_data: [],
      models_data: []
    }
  },
  methods: {
    /* Fill in the brand input */
    fetch_data() {
      fetch(`${this.url_route}/api/vehicles-data`)
        .then(response => response.json())
        .then(data => {
          this.vehicles_data = data;
        })
        .catch(error => {
          console.error('Houve um erro ao buscar os dados: ', error);
        });
    },

    /* Fill in the model input */
    fill_select(brand) {
      $.ajax({
        url: `${this.url_route}/api/models/${brand}`,
        method: 'GET',
        success: (data) => {
          this.old_brand = brand;
          $('#model').empty();
          $('#model').append(`<option value="" ${this.old.model === '' ? 'selected' : ''}>Selecione</option>`);
          data.models.forEach(model => {
            $('#model').append(`<option value="${model}" ${this.old.model === model ? 'selected' : ''}>${model}</option>`);
          });
        },
        error: (error) => {
          console.error('Erro ao fazer a solicitação: ', error)
        }
      })
    }
  },
  mounted() {
    if (Object.values(this.old).length > 0) {
      document.getElementById('modal-button').click();
    }
    this.fetch_data();
    $(this.$refs.brand).select2({
      dropdownParent: $('#add-modal'),
      width: '100%'
    });

    $(this.$refs.model).select2({
      dropdownParent: $('#add-modal'),
      width: '100%'
    });

    $(this.$refs.color).select2({
      dropdownParent: $('#add-modal'),
      width: '100%'
    });


    /* Error ou normal */
    $('[aria-labelledby="select2-brand-container"]').css('border-color', this.errors.brand ? '#D93845' : '#DEE2E6');
    $('[aria-labelledby="select2-model-container"]').css('border-color', this.errors.model ? '#D93845' : '#DEE2E6');
    $('[aria-labelledby="select2-color-container"]').css('border-color', this.errors.color ? '#D93845' : '#DEE2E6');

    /* Verify if the old data exists */
    if (this.old_brand !== '') {
      this.fill_select(this.old_brand);
    }

    /* If the brand has changed, activate the model input. */
    $(this.$refs.brand).on('change', () => {
      let selected_brand = $('#brand').val();
      this.fill_select(selected_brand);
    });

    Inputmask({
      regex: "^[A-Za-z]{3}-[0-9]{1}[A-Za-z0-9]{1}[0-9]{2}$",
      placeholder: "___-____",
      showMaskOnHover: true,
    }).mask(this.$refs.plate);
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
