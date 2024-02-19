<template>
  <div class="container">
    <div class="row">
      <div class="col-12 px-4"
        id="container-title">
        <h2><i class="fa-solid fa-chart-pie"></i> DASHBOARD</h2>
      </div>
      <div class="col-12" id="graph-container">
        <div class="col-3 value-graph"></div>
        <div class="col-3 value-graph"></div>
        <div class="col-3 value-graph"></div>
      </div>
      <div class="col-12" id="graph-container">
        <div class="line-graph"></div>
      </div>
      <div class="col-12 mb-5" id="graph-container">
        <div class="col-5 pizza-graph"></div>
        <div class="col-5 pizza-graph"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log('Component mounted.')
  }
}
</script>
<style scoped>
#container-title {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 40px 0px 20px 0px;
}

h2 {
  margin: 0px;
}

#graph-container {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
  gap: 10px;
  margin: 10px 0px;
}

.value-graph {
  height: 120px;
  background-color: red;
  flex-grow: 1;
  min-width: 200px;
  border-radius: 8px;
}

.line-graph {
  flex-grow: 1;
  background-color: blue;
  height: 120px;
  border-radius: 8px;
}

.pizza-graph {
  flex-grow: 1;
  background-color: aqua;
  height: 300px;
  min-width: 200px;
  border-radius: 8px;
}


</style>
