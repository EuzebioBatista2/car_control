<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-user"></i> VEÍCULOS</h2>
      </div>
    </div>
    <div class="row"
      id="edit-container">
      <div class="col-12 black-container">
        <div class="inputs">
          <div class="container-sub-title mb-5">
            <h4>Editar dados <i class="fa-solid fa-pen-to-square mx-2"></i></h4>
          </div>
          <form :action="route + '/' + review.vehicle_id + '/' + review.id"
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

              <!-- Review data -->
              <div class="mb-3">
                <div class="d-flex w-100 justify-content-start">
                  <label for="date_review"
                    class="form-label d-inline-flex mx-2 mb-1">Data de revisão:</label>
                </div>
                <input class="form-control search-item"
                  type="datetime-local"
                  name="date_review"
                  id="date_review"
                  :value="old_date_review"
                  aria-label="review date">
                <span v-if="errors.date_review"
                  class="invalid-feedback"
                  role="alert">
                  <strong>{{ errors.date_review[0] }}</strong>
                </span>
              </div>

              <!-- Completed -->
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input"
                    type="checkbox"
                    name="completed"
                    id="completed" :checked="old_completed === '1'" >
                  <label class="form-check-label"
                    for="completed">
                    Revisão concluída?
                  </label>
                </div>
              </div>
            </div>

            <!-- Problems -->
            <div class="item-container">
              <div class="mb-3">
                <div class="d-flex w-100 justify-content-start">
                  <label for="problems"
                    class="form-label d-inline-flex mx-2 mb-1">Problema(s) encontrado(s):</label>
                </div>
                <textarea :class="errors.problems ? 'form-control is-invalid' : 'form-control'"
                    placeholder="Informe os problemas encontrados"
                    id="problems"
                    name="problems"
                    style="height: 100px">{{ old_problems }}</textarea>
                <span v-if="errors.problems"
                  class="text-danger"
                  style="font-size: 0.875em; font-weight: bolder;">
                  <strong>{{ errors.problems[0] }}</strong>
                </span>
              </div>

              <div class="button-container">
                <a :href="route + '/' + review.vehicle_id"
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
  props: ['review', 'columns', 'csrf_token', 'errors', 'old', 'route'],
  data() {
    return {
      old_problems: this.old.problems ?? this.review.problems ?? '',
      old_completed: this.old.completed ?? this.review.completed ?? '',
      old_date_review: this.old.date_review ?? this.review.date_review ?? '',
    }
  },
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
  min-width: 20px;
}

.button-container {
  display: flex;
  gap: 10px;
  justify-content: end;
}

/* Media */
@media (max-width: 990px) {
  .container {
    padding: 0px;
  }

  .black-container {
    padding: 0px;
  }
}
</style>
