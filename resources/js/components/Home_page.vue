<template>
  <div class="container h-100">
    <div class="row h-100">
      <div class="container-page">
        <div>
          <img src="img/Logo.png"
            alt="Logo de carro, vermelho e branco"
            id="logo-img">
        </div>
        <div class="content mb-5">
          <div>
            <h2 class="font-home text-white">
              CONHEÇA MAIS SOBRE
            </h2>
            <h2 class="font-home text-danger">
              NOSSAS FUNÇÕES
            </h2>
          </div>
          <a v-if="auth === 'login'" href="/login" class="d-flex justify-content-center align-items-center gap-2 btn btn-danger button-link">Faça o login <i class="fa-solid fa-arrow-right"></i></a>
          <a v-else href="/dashboard" class="d-flex justify-content-center align-items-center gap-2 btn btn-danger button-link">Entrar <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['auth']
}
</script>
<style scoped>

#logo-img {
  display: flex;
  width: auto;
  height: 200px;
}
.container-page {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.button-link {
  font-size: 18px;
}

.font-home {
  font-size: 40px;
  font-weight: bold;
  margin: 0;
}

@media (max-width: 480px) {
  .font-home {
    font-size: 30px;
  }
}

@media (max-width: 767px) {

  .container-page {
    align-items: center;
  }
  .content {
    flex-direction: column;
    align-items: center;
    gap: 20px;
  }
}
</style>
