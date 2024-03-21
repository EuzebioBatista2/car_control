<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-address-book mx-2"></i> REVISÃO</h2>
        <a href="/vehicles"
          class="back-link"><i class="fa-solid fa-left-long"></i></a>
      </div>
      <div class="col-12 px-4">
        <p>Para sinalizar que a revisão foi concluída, basta marca a opção referente aos dados do veículo na coluna <strong>CONCLUÍDO</strong>.</p>
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
                  :action="route + '/search'"
                  method="GET">
                  <!-- Search -->
                  <select class="form-select"
                    id="select"
                    name="select">
                    <option :selected="old_select === 'id'" value="id">Id</option>
                    <option :selected="old_select === 'name'" value="name">Nome</option>
                    <option :selected="old_select === 'brand'" value="brand">Marca</option>
                    <option :selected="old_select === 'model'" value="model">Modelo</option>
                    <option :selected="old_select === 'year'" value="year">Ano</option>
                    <option :selected="old_select === 'color'" value="color">Cor</option>
                    <option :selected="old_select === 'problems'" value="problems">Problemas</option>
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
          </div>
          <div class="card-body table-over">
            <!-- Table columns -->
            <table v-if="reviews.data && Object.keys(reviews.data).length > 0"
              class="table table-dark table-striped table-hover">
              <thead>
                <tr>
                  <th v-for="column in columns"
                    scope="col" :style="column === 'Problemas' ? 'max-width: 600px;' : ''">{{ column }}</th>
                  <th scope="col">Concluído</th>
                  <th scope="col">Revisão</th>
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
                    <span v-else-if="review.vehicle_id !== data" class="data" style="overflow-wrap: break-word; max-width: 600px;margin: 0px auto;">{{ data }}</span>
                    <a v-else :href="route + '/' + data" class="btn btn-primary">Revisão</a>  
                  </th>
                </tr>
              </tbody>
            </table>
            <p v-else
              class="text-white">Não há dados cadastrados no momento ou informações não encontradas.</p>
          </div>

          <!-- Paginate -->
          <div v-if="reviews.data && Object.keys(reviews.data).length > 0"
            class="card-footer text-body-secondary container-footer">
            <nav aria-label="Page navigation" class="nav-page">
              <ul class="pagination">
                <li v-for="page in reviews.links"
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

export default {
  props: ['reviews', 'columns', 'csrf_token', 'errors', 'old', 'route', 'select', 'data'],
  data() {
    return {
      old_data: this.data ?? '',
      old_select: this.select === '' ? 'id' : this.select
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

/* Table */
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

.nav-page {
  overflow-x: auto;
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

.container-footer {
  display: flex;
  width: 100%;
  align-items: center;
  justify-content: center;
}

/* Table */
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
