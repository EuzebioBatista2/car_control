<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-car mx-2"></i> VEÍCULOS</h2>
        <a href="/customers"
          class="back-link"><i class="fa-solid fa-left-long"></i></a>
      </div>
      <div class="col-12 px-4">
        <p>Para cadastrar o veiculos, o Admin deverá ir na página <strong>CLIENTES</strong>, clicando em
          <strong>Veículos</strong>. Caso haja cadastro de veículo o Admin também pode clicar em <strong>Veículos</strong> na página
          <strong>VEÍCULOS</strong>.
        </p>
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
          </div>
          <div class="card-body table-over">
            <!-- Table columns -->
            <table v-if="vehicles.data && Object.keys(vehicles.data).length > 0"
              class="table table-dark table-striped table-hover">
              <thead>
                <tr>
                  <th v-for="column in columns"
                    scope="col">{{ column }}</th>
                  <th scope="col">Adicionar</th>
                </tr>
              </thead>
              <tbody>
                <!-- Table data -->
                <tr v-for="vehicle in vehicles.data">
                  <td scope="row">
                    <span class="data">{{ vehicle.id }}</span>
                  </td>
                  <td scope="row">
                    <span class="data">{{ vehicle.name }}</span>
                  </td>
                  <td scope="row">
                    <span class="data">{{ vehicle.plate }}</span>
                  </td>
                  <td scope="row">
                    <span class="data">{{ vehicle.brand }}</span>
                  </td>
                  <td scope="row">
                    <span class="data">{{ vehicle.model }}</span>
                  </td>
                  <td scope="row">
                    <span class="data">{{ vehicle.year }}</span>
                  </td>
                  <td scope="row">
                    <span class="data">{{ vehicle.color }}</span>
                  </td>
                  <td scope="row">
                    <span class="data">{{ vehicle.steering_system }}</span>
                  </td>
                  <td scope="row">
                    <a
                      :href="route + '/' + vehicle.customer_id"
                      class="btn btn-primary">Veículos</a>
                  </td>
                </tr>
              </tbody>
            </table>
            <p v-else
              class="text-white">Não há dados cadastrados no momento ou informações não encontradas.</p>
          </div>
          <!-- Paginate -->
          <div v-if="vehicles.data && Object.keys(vehicles.data).length > 0"
            class="card-footer text-body-secondary container-footer">
            <nav aria-label="Page navigation" class="nav-page">
              <ul class="pagination">
                <li v-for="page in vehicles.links"
                  :key="page"
                  class="page-item">
                  <a v-if="page.label === 'pagination.previous'"
                    class="page-link bg-dark text-white"
                    :href="page.url"
                    aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                  <a v-else-if="page.label === 'pagination.next'"
                    class="page-link bg-dark text-white"
                    :href="page.url"
                    aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                  <a v-else
                    class="page-link bg-dark text-white"
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
  props: ['vehicles', 'columns', 'csrf_token', 'errors', 'old', 'route', 'search', 'select', 'data'],
  data() {
    return {
      old_data: this.data ?? '',
      old_select: this.select === '' ? 'id' : this.select
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
