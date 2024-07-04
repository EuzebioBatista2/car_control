<template>
  <div class="container"
    ref="data">
    <div class="success">
      <p>PDF baixado com sucesso</p>
      <p>pode fechar a guia do navegador.</p>
      <img src="/gif/Success.gif"
        alt="Confirmando o download"
        height="100"
        width="100">
      <p>ou clique aqui: <a :href="route_dashboard">Página inicial</a></p>
    </div>
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><img src="/icons/chart-pie-solid.webp"
            alt="Ícone do gráfico de pizza"
            class="mx-2 d-inline-flex"
            width="28"
            height="28" /> DASHBOARD</h2>
      </div>
      <div class="col-12"
        id="graph-container"
        style="margin-bottom: 100px;">
        <div class="col-3 value-graph">
          <span class="title-value-graph">
            <img src="/icons/user-solid.webp"
              alt="Ícone de usuário"
              class="mx-2 d-inline-flex"
              width="18"
              height="20" /> Cliente(s):
          </span>
          <h1 class="query-value-graph mx-2">{{ customers_graph }}</h1>
        </div>
        <div class="col-3 value-graph">
          <span class="title-value-graph">
            <img src="/icons/car-solid.webp"
              alt="Ícone de carro"
              class="mx-2 d-inline-flex"
              width="20"
              height="20" /> Veículo(s):
          </span>
          <h1 class="query-value-graph mx-2">{{ vehicles_graph }}</h1>
        </div>
        <div class="col-3 value-graph">
          <span class="title-value-graph">
            <img src="/icons/address-book-solid.webp"
              alt="Ícone de revisões"
              class="mx-2 d-inline-flex"
              width="20"
              height="20" /> Revisão(ões):
          </span>
          <h1 class="query-value-graph mx-2">{{ reviews_graph }}</h1>
        </div>
      </div>
      <div class="col-12"
        id="graph-container"
        style="margin-bottom: 30px;">
        <div class="line-graph">
          <div class="title-graph">
            <h5 class="mb-0 text-white">Número de registros nos ultimos 7 dias:</h5>
            <hr />
          </div>
          <div class="graph-canvas-line">
            <canvas id="line_graph_canvas"
              ref="line_graph"></canvas>
          </div>
        </div>
      </div>
      <div class="col-12 mb-3"
        id="graph-container">
        <div class="col-5 total-graph">
          <div class="title-graph">
            <h5 class="mb-0 text-white">TOP 5 Clientes com mais veículos:</h5>
            <hr />
          </div>
          <div class="graph-canvas">
            <canvas ref="top_customers_graph"
              id="top_customers_graph"></canvas>
          </div>
        </div>
        <div class="col-5 total-graph">
          <div class="title-graph">
            <h5 class="mb-0 text-white">Distribuição por Gênero:</h5>
            <hr />
          </div>
          <div class="graph-canvas">
            <canvas ref="genders_graph"
              id="genders_graph"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="row"
      style="padding: 0px 10px;">
      <div class="col-12 px-4"
        id="container-table">
        <h2><img src="/icons/table-cells-large-solid.webp"
            alt="Ícone de tabela"
            class="me-2 d-inline-flex"
            width="28"
            height="28" /> TABELAS</h2>
      </div>
      <div class="col-12 table-values">
        <div class="title-graph">
          <h5 class="mb-0 text-white">Lista de clientes cadastrados:</h5>
          <hr />
        </div>
        <div class="table-over">
          <table v-if="customers_columns && customers_columns.length > 0"
            class="table-color">
            <thead>
              <tr>
                <!-- Table columns -->
                <th v-for="column in customers_columns"
                  class="th-td text-table-th"
                  scope="col">{{ column }}</th>
              </tr>
            </thead>
            <tbody>
              <!-- Table data -->
              <tr v-for="customer in customers_table">
                <td v-for="data in customer"
                  class="th-td text-table-td"
                  scope="row">
                  <span v-if="data === 'M'">
                    <img src="/icons/mars-solid.webp"
                      alt="Ícone de revisões"
                      class="d-inline-flex"
                      width="12"
                      height="14" /></span>
                  <span v-else-if="data === 'F'">
                    <img src="/icons/venus-solid.webp"
                      alt="Ícone de revisões"
                      class="d-inline-flex"
                      width="12"
                      height="14" /></span>
                  <span v-else-if="data === 'N'"><img src="/icons/transgender-solid.webp"
                      alt="Ícone de revisões"
                      class="d-inline-flex"
                      width="14"
                      height="14" /></span>
                  <span v-else>{{ data }}</span>
                </td>
              </tr>
            </tbody>
          </table>
          <p v-else
            class="text-table-th">Não há dados cadastrados no momento ou informações não encontradas.</p>
        </div>
      </div>

      <div class="col-12 table-values">
        <div class="title-graph">
          <h5 class="mb-0 text-white">Lista de veículos cadastrados:</h5>
          <hr />
        </div>
        <div class="table-over">
          <table v-if="vehicles_columns && vehicles_columns.length > 0"
            class="table-color">
            <thead>
              <tr>
                <th v-for="column in vehicles_columns"
                  class="th-td text-table-th"
                  scope="col">{{ column }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="customer in vehicles_table">
                <td v-for="data in customer"
                  scope="row"
                  class="th-td text-table-td">
                  <span>{{ data }}</span>
                </td>
              </tr>
            </tbody>
          </table>
          <p v-else
            class="text-table-th">Não há dados cadastrados no momento ou informações não encontradas.</p>
        </div>
      </div>

      <div class="col-12 table-values">
        <div class="title-graph">
          <h5 class="mb-0 text-white">Lista de revisões cadastradas:</h5>
          <hr />
        </div>
        <div class="table-over">
          <table v-if="reviews_columns && reviews_columns.length > 0"
            class="table-color">
            <thead>
              <tr>
                <!-- Table columns -->
                <th v-for="column in reviews_columns"
                  class="th-td text-table-th"
                  scope="col">{{ column }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="customer in reviews_table">
                <!-- Table data -->
                <td v-for="data in customer"
                  class="th-td text-table-td"
                  scope="row">
                  <span v-if="is_date(data)">{{ format_date(data) }}</span>
                  <span v-else-if="data === '1'">
                    <input type="checkbox"
                      class="form-check-input"
                      checked
                      disabled>
                  </span>
                  <span v-else-if="data === '0'">
                    <input type="checkbox"
                      class="form-check-input"
                      disabled>
                  </span>
                  <span v-else>{{ data }}</span>
                </td>
              </tr>
            </tbody>
          </table>
          <p v-else
            class="text-table-th">Não há dados cadastrados no momento ou informações não encontradas.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import jsPDF from 'jspdf';

export default {
  props: [
    'customers_graph',
    'vehicles_graph',
    'reviews_graph',
    'line_graph',
    'genders_graph',
    'top_customers_graph',
    'customers_table',
    'customers_columns',
    'vehicles_table',
    'vehicles_columns',
    'reviews_table',
    'reviews_columns',
    'route_dashboard'
  ],
  methods: {
    is_date(value) {
      return moment(value, 'YYYY-MM-DD HH:mm:ss', true).isValid();
    },
    format_date(date) {
      return moment(date).format('DD/MM/YYYY HH:mm:ss');
    },
    convert_graph_to_image(graph_ref) {
      const canvas = this.$refs[graph_ref];
      const data_url = canvas.toDataURL();
      const img = new Image();
      img.src = data_url;
      img.id = graph_ref
      canvas.parentNode.replaceChild(img, canvas);
    },
    generate_pdf() {
      const pdf = new jsPDF('l', 'px', 'a4');
      const data = this.$refs.data;

      const cloned_data = data.cloneNode(true);
      cloned_data.style.width = '630px'
      pdf.html(cloned_data, {
        callback: function (pdf) {
          cloned_data.style.width = '100%'
          pdf.save('vehicles_control.pdf');
          $('.loading').css('display', 'none');
          $('.success').css('display', 'flex');
        }
      });
    },
  },
  mounted() {
    return new Promise(resolve => {
      const records = this.$refs.line_graph;
      new Chart(records, {
        type: 'line',
        data: {
          labels: this.line_graph.labels,
          datasets: this.line_graph.datasets
        },
        options: {
          plugins: {
            legend: {
              display: false
            }
          },
          animation: {
            onComplete: () => {
              this.convert_graph_to_image('line_graph');
              resolve();
            }
          }
        }
      });
    }).then(() => {
      return new Promise((resolve) => {
        const top_customers = this.$refs.top_customers_graph;
        new Chart(top_customers, {
          type: 'pie',
          data: this.top_customers_graph,
          options: {
            animation: {
              onComplete: () => {
                this.convert_graph_to_image('top_customers_graph');
                resolve();
              }
            }
          }
        });
      })
    }).then(() => {
      return new Promise((resolve) => {
        const genders = this.$refs.genders_graph;
        new Chart(genders, {
          type: 'bar',
          data: this.genders_graph,
          options: {
            plugins: {
              legend: {
                display: false
              }
            },
            animation: {
              onComplete: () => {
                this.convert_graph_to_image('genders_graph');
                resolve();
              }
            }
          }
        });
      })
    }).then(() => {
      this.generate_pdf();
    })
  }
}
</script>

<style scoped>
/* Container */
#container-title {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 40px 0px 20px 0px;
}

#container-table {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 20px 0px;
}

h2 {
  display: flex;
  align-items: center;
  margin: 0px;
  font-size: 28px;
}

/* Chart */
#graph-container {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
  gap: 10px;
  margin: 5px 0px;
}

.title-graph {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.icon {
  height: 28px;
  width: 28px;
}

.title-graph h5 {
  padding: 8px 12px;
}

.value-graph {
  height: 120px;
  background-color: #212529;
  flex-grow: 1;
  min-width: 200px;
  border-radius: 8px;
  padding: 10px;
}

.graph-canvas {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 90% !important;
  width: 100%;
  margin: auto;
  overflow-x: scroll;
}

.graph-canvas-line {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 90% !important;
  margin: auto;
}

#line_graph_canvas {
  height: 300px !important;
}

.title-value-graph {
  font-size: 18px;
  color: white;
}

.query-value-graph {
  font-size: 42px;
  color: white;
}

.line-graph {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  background-color: #212529;
  height: 420px;
  border-radius: 8px;
  overflow-x: auto;
}

.total-graph {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  background-color: #212529;
  height: 420px;
  min-width: 200px;
  border-radius: 8px;
}

#top_customers_graph {
  width: 260px !important;
  height: auto !important;
}

#genders_graph {
  width: 400px !important;
}

hr {
  display: inline-flex;
  border: 1px solid white;
  color: white;
  width: 100%;
  margin: 0;
}

/* Customers_table */
.table-over {
  padding: 20px;
  overflow-x: scroll;
}

.table-over table {
  width: 100%;
  min-width: 380px;
  text-align: center;
}

.th-td {
  padding: 0.5rem 0.5rem;
  border-bottom: 1px solid #44474A;
}

.table-color {
  background-color: #212529;
}

.text-table-th {
  color: white;
}

.text-table-td {
  color: gray;
}

.table-values {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  background-color: #212529;
  border-radius: 8px;
  padding: 0px;
  margin: 5px 0px;

}

.data {
  max-width: 400px;
  overflow-wrap: break-word;
}
</style>;
