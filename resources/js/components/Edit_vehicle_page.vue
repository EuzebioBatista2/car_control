<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-car mx-2"></i> VEÍCULOS</h2>
      </div>
    </div>
    <div class="row"
      id="edit-container">
      <div class="col-12 black-container">
        <div class="inputs">
          <div class="container-sub-title mb-5">
            <h4>Editar dados <i class="fa-solid fa-pen-to-square mx-2"></i></h4>
          </div>
          <form :action="route + '/' + customer.id + '/' + vehicle.id"
            method="POST"
            class="form-container">

            <!-- Token -->
            <input type="hidden"
              name="_token"
              :value="csrf_token">

            <!-- Put method -->
            <input type="hidden"
              name="_method"
              value="PUT">

            <div class="item-container">
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
            </div>

            <!-- Color -->
            <div class="item-container">
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

              <div class="button-container">
                <a :href="route + '/' + customer.id"
                  class="btn btn-secondary">Voltar</a>
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

export default {
  props: ['vehicle', 'customer', 'csrf_token', 'errors', 'old', 'route', 'url_route'],
  data() {
    return {
      old_plate: this.old.plate ?? this.vehicle.plate ?? '',
      old_brand: this.old.brand ?? this.vehicle.brand ?? '',
      old_model: this.old.model ?? this.vehicle.model ?? '',
      old_year: this.old.year ?? this.vehicle.year ?? '',
      old_color: this.old.color ?? this.vehicle.color ?? '',
      old_steering_system: this.old.steering_system ?? this.vehicle.steering_system ?? '',
      old_type_of_fuel: this.old.type_of_fuel ?? this.vehicle.type_of_fuel ?? '',
      vehicles_data: [],
      models_data: []
    }
  },
  methods: {
    /* Fill in the vehicle selection input */
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

    /* Select the old brand if it exists. */
    fill_select(brand) {
      $.ajax({
        url: `${this.url_route}/api/models/${brand}`,
        method: 'GET',
        success: (data) => {
          this.old_brand = brand;
          $('#model').empty();
          $('#model').append(`<option value="" ${this.old_model === '' ? 'selected' : ''}>Selecione</option>`);
          if (data.models) {
            data.models.forEach(model => {
              $('#model').append(`<option value="${model}" ${this.old_model === model ? 'selected' : ''}>${model}</option>`);
            });
          }
        },
        error: (error) => {
          console.error('Erro ao fazer a solicitação: ', error)
        }
      })
    }
  },
  mounted() {
    this.fetch_data();

    $(this.$refs.brand).select2({
      width: '100%'
    });

    $(this.$refs.model).select2({
      width: '100%'
    });

    $(this.$refs.color).select2({
      width: '100%'
    });

    /* Error or normal  */
    $('[aria-labelledby="select2-brand-container"]').css('border-color', this.errors.brand ? '#D93845' : '#DEE2E6');
    $('[aria-labelledby="select2-model-container"]').css('border-color', this.errors.model ? '#D93845' : '#DEE2E6');
    $('[aria-labelledby="select2-color-container"]').css('border-color', this.errors.color ? '#D93845' : '#DEE2E6');

    $(this.$refs.brand).on('change', () => {
      let selected_brand = $('#brand').val();
      this.fill_select(selected_brand);
    });

    if (this.old_brand !== '') {
      this.fill_select(this.old_brand);
    }

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

.button-container {
  display: flex;
  gap: 10px;
  justify-content: end;
}

/* Média */
@media (max-width: 576px) {
  .container {
    padding: 0px;
  }

  .black-container {
    padding: 0px;
  }
}
</style>
