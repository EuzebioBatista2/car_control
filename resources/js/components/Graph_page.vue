<template>
  <div class="container">
    <div class="row">
      <div class="col-12"
        id="container-title">
        <h2 class="title-item"><i class="fa-solid fa-chart-pie mx-2"></i> DASHBOARD</h2>
        <div class="title-item title-link">
          <a :href="route_pdf"
            target="_blank"
            class="btn btn-danger">
            <i class="fa-solid fa-file-pdf me-1"></i> BAIXA PDF
          </a>
          <a :href="route_excel"
            target="_blank"
            class="btn btn-success"><i class="fa-solid fa-file-excel me-2"> </i>BAIXA EXCEL
          </a>
        </div>
      </div>
      <div class="col-12"
        id="graph-container">
        <div class="col-3 value-graph">
          <span class="title-value-graph">
            <i class="fa-solid fa-user mx-2"></i> Cliente(s):
          </span>
          <h1 class="query-value-graph mx-2">{{ customers }}</h1>
        </div>
        <div class="col-3 value-graph">
          <span class="title-value-graph">
            <i class="fa-solid fa-car mx-2"></i> Veículo(s):
          </span>
          <h1 class="query-value-graph mx-2">{{ vehicles }}</h1>
        </div>
        <div class="col-3 value-graph">
          <span class="title-value-graph">
            <i class="fa-solid fa-address-book mx-2"></i> Revisão(ões):
          </span>
          <h1 class="query-value-graph mx-2">{{ reviews }}</h1>
        </div>
      </div>
      <div class="col-12"
        id="graph-container">
        <div class="line-graph">
          <div class="title-graph">
            <h5 class="mb-0 text-white">Número de registros nos ultimos 7 dias:</h5>
            <hr />
          </div>
          <div class="graph-canvas">
            <canvas id="line-canvas"
              ref="line_graph"></canvas>
          </div>
        </div>
      </div>
      <div class="col-12 mb-5"
        id="graph-container">
        <div class="col-5 total-graph">
          <div class="title-graph">
            <h5 class="mb-0 text-white">TOP 5 Clientes com mais veículos:</h5>
            <hr />
          </div>
          <div class="graph-canvas">
            <canvas ref="top_customers"
              id="top_customers"></canvas>
          </div>
        </div>
        <div class="col-5 total-graph">
          <div class="title-graph">
            <h5 class="mb-0 text-white">Distribuição por Gênero:</h5>
            <hr />
          </div>
          <div class="graph-canvas">
            <canvas ref="genders"
              id="genders"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'customers',
    'vehicles',
    'reviews',
    'line_graph',
    'genders_total',
    'top_customers',
    'route_pdf',
    'route_excel'
  ],
  mounted() {
    /* The last 7 days chart */
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
        }
      }
    });

    /* Top customers chart */
    const top_customers = this.$refs.top_customers;
    new Chart(top_customers, {
      type: 'pie',
      data: this.top_customers,
    });

    /* Genders chart */
    const genders = this.$refs.genders;
    new Chart(genders, {
      type: 'bar',
      data: this.genders_total,
      options: {
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  }
}
</script>

<style scoped>
/* Container */
#container-title {
  display: inline-flex;
  justify-content: space-between;
  flex-wrap: wrap;
  align-items: center;
  padding: 40px 12px 20px 12px;
}

.title-item {
  flex-grow: 1;
  min-width: 200px;
}

.title-link {
  display: flex;
  justify-content: end;
  gap: 10px;
}

h2 {
  margin: 0px;
}

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
  border: 2px solid #212529;
}

.graph-canvas {
  display: inline-flex;
  align-items: center;
  height: 100%;
  margin: auto;
}

#line-canvas {
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
  border: 2px solid #212529;
}

.total-graph {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  background-color: #212529;
  height: 420px;
  min-width: 200px;
  border-radius: 8px;
  border: 2px solid #212529;
}

#top_customers {
  width: 300px !important;
}

#genders {
  width: 300px !important;
}

hr {
  display: inline-flex;
  border: 1px solid gray;
  color: white;
  width: 100%;
  margin: 0;
}

/* Media */
@media(max-width: 767px) {

  #container-title {
    gap: 10px;
  }

  .title-item {
    flex-wrap: wrap;
  }

  .title-item a {
    flex-grow: 1;
  }

  #top_customers {
    width: 240px !important;
  }

  #genders {
    width: 220px !important;
  }
}
</style>
