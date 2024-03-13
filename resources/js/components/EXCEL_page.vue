<template>
  <div class="container"
    ref="data">
    <div class="success">
      <p>Excel baixado com sucesso</p>
      <p>pode fechar a guia do navegador.</p>
      <img src="/gif/Success.gif"
        alt="Confirmando o download"
        height="100"
        width="100">
      <p>ou clique aqui: <a :href="route_dashboard">Página inicial</a></p>
    </div>
    <div class="row"
      style="padding: 0px 10px;">
      <div class="col-12 px-4"
        id="container-table">
        <h2><img src="/icons/table-cells-large-solid.png"
            alt="Ícone de tabela"
            class="me-2 d-inline-flex"
            width="28"
            height="28" /> TABELAS</h2>
      </div>
      <div class="col-12 table-values">
        <div class="table-over">
          <!-- Table columns -->
          <table v-if="customers_columns && customers_columns.length > 0"
            class="table-color"
            ref="customers_table">
            <thead>
              <tr>
                <th colspan="6"
                  class="th-td text-table-th">Lista de clientes cadastrados</th>
              </tr>
              <tr>
                <!-- Table data -->
                <th v-for="column in customers_columns"
                  class="th-td text-table-th"
                  scope="col">{{ column }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="customer in customers_table">
                <td v-for="data in customer"
                  class="th-td text-table-td"
                  scope="row">
                  <span v-if="data === 'M'">Masculino</span>
                  <span v-else-if="data === 'F'">Feminino</span>
                  <span v-else-if="data === 'N'">Não definido</span>
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
        <div class="table-over">
          <!-- Table columns -->
          <table v-if="vehicles_columns && vehicles_columns.length > 0"
            class="table-color"
            ref="vehicles_table">
            <thead>
              <tr>
                <th colspan="7"
                  class="th-td text-table-th">Lista de veículos cadastrados</th>
              </tr>
              <tr>
                <th v-for="column in vehicles_columns"
                  class="th-td text-table-th"
                  scope="col">{{ column }}</th>
              </tr>
            </thead>
            <tbody>
              <!-- Table data -->
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

        <div class="table-over">
          <!-- Table columns -->
          <table v-if="reviews_columns && reviews_columns.length > 0"
            class="table-color"
            ref="reviews_table">
            <thead>
              <tr>
                <th colspan="7"
                  class="th-td text-table-th">Lista de revisões cadastradas</th>
              </tr>
              <tr>
                <th v-for="column in reviews_columns"
                  class="th-td text-table-th"
                  scope="col">{{ column }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="customer in reviews_table">
                <td v-for="data in customer"
                  class="th-td text-table-td"
                  scope="row">
                  <span v-if="is_date(data)">{{ format_date(data) }}</span>
                  <span v-else-if="data === '1'">Sim</span>
                  <span v-else-if="data === '0'">Não</span>
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
import ExcelJS from 'exceljs';

export default {
  props: [
    'customers_table',
    'customers_columns',
    'vehicles_table',
    'vehicles_columns',
    'reviews_table',
    'reviews_columns',
    'route_dashboard',
  ],
  methods: {
    is_date(value) {
      return moment(value, 'YYYY-MM-DD HH:mm:ss', true).isValid();
    },

    format_date(date) {
      return moment(date).format('DD/MM/YYYY HH:mm:ss');
    },

    async generate_excel() {
      const workbook = new ExcelJS.Workbook();

      /* Creating page */
      const customers_sheet = workbook.addWorksheet('Clientes');
      const vehicles_sheet = workbook.addWorksheet('Veículos');
      const reviews_sheet = workbook.addWorksheet('Revisões');

      const add_data_to_sheet = (sheet, data, columns, title) => {
        /* Add title and style */
        const title_data = sheet.addRow(title)
        sheet.mergeCells(1, 1, 1, columns.length);
        title_data.font = { bold: true, size: 14 };

        /* Add columns */
        const columns_data = sheet.addRow(columns);
        columns_data.font = { bold: true };

        /* Formating data */
        data.forEach(row => {
          const row_data = [];

          for (const key in row) {
            let value = row[key];

            /* Translate the specific values, if necessary */
            if (key === 'gender') {
              if (value === 'M') {
                value = 'Masculino';
              } else if (value === 'F') {
                value = 'Feminino';
              } else if (value === 'N') {
                value = 'Não definido';
              }
            } else if (key === 'completed') {
              if (value === '0') {
                value = 'Não';
              } else if (value === '1') {
                value = 'Sim';
              }
            } else if (key === 'date_review') {
              value = this.format_date(row[key])
            }

            row_data.push(value); /* Add row */
          }

          sheet.addRow(row_data); /* Add row */
        });

        /* Centered text */
        sheet.eachRow({ includeEmpty: false }, function (row) {
          row.alignment = { vertical: 'middle', horizontal: 'center' };
        });

        const borders = {
          top: { style: 'thin' },
          left: { style: 'thin' },
          bottom: { style: 'thin' },
          right: { style: 'thin' },
        };
        sheet.eachRow((row) => {
          row.eachCell((cell) => {
            cell.border = borders;
          });
        });

        // Auto ajuste de colunas
        sheet.columns.forEach(column => {
          const max_length = column.values.reduce((acc, val) => {
            const value_length = val ? val.toString().length : 0;
            return Math.max(acc, value_length);
          }, 0);
          column.width = max_length < 20 ? 20 : max_length; /* Automatic column adjustment */
        });
      };

      /* Add formatted data */
      add_data_to_sheet(customers_sheet, this.customers_table, this.customers_columns, ['Lista de clientes cadastrados']);
      add_data_to_sheet(vehicles_sheet, this.vehicles_table, this.vehicles_columns, ['Lista de veículos cadastrados']);
      add_data_to_sheet(reviews_sheet, this.reviews_table, this.reviews_columns, ['Lista de revisões cadastradas']);

      /* Write file */
      const buffer = await workbook.xlsx.writeBuffer();

      const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

      const url = window.URL.createObjectURL(blob);

      /* Create link and click on it to download the file */
      const a = document.createElement('a');
      a.href = url;
      a.download = 'vehicles_control.xlsx';
      a.click();

      // Release the blob url
      window.URL.revokeObjectURL(url);

      /* Update da loading */
      $('.loading').css('display', 'none');
      $('.success').css('display', 'flex');
    }
  },
  mounted() {
    this.generate_excel()
  }
}
</script>

<style scoped>
/* container */
.container {
  position: relative;
}

#container-table {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 20px 0px;
}

.icon {
  height: 28px;
  width: 28px;
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
</style>
