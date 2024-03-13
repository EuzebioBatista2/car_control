<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config("app.name", "Laravel") }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Icon -->
  <link rel="icon" type="image/ico" href="{{ asset("icons/favicon.ico") }}">

  <!-- Style -->
  <link rel="stylesheet" href="{{ asset("css/styles.css") }}">

  <!-- Scripts -->
  @vite(["resources/sass/app.scss", "resources/js/app.js"])
</head>

<body>
  <div id="app" class="container-fluid">
    <main class="row container-auth-register">
      <div class="content-auth col-md-12 col-lg-5">
        @yield("content")
      </div>

      <div class="col-md-12 col-lg-7 background-auth-register">
        <div class="backgroud-dark">
          <h4 class="contact-title">Conheça mais sobre meus projetos</h4>
          <nav class="contact-link">
            <a href="https://www.linkedin.com/in/euzebio-batista/" class="btn btn-light btn-lg">
              <i class="fa-brands fa-linkedin text-primary mx-2"></i> Linkedin
            </a>
            <a href="https://portfolio-euzebiobatista.vercel.app" class="btn btn-light btn-lg">
              <i class="fa-solid fa-user-tie text-info-emphasis mx-2"></i> Portfolio
            </a>
            <a href="https://github.com/EuzebioBatista2" class="btn btn-light btn-lg">
              <i class="fa-brands fa-github git-icon mx-2"></i> GitHub
            </a>
          </nav>
        </div>
      </div>
    </main>
    <footer class="row container-footer">
      <div class="col-12 content-footer">
        <p>Euzebio Batista &copy; 2024.</p>
      </div>
    </footer>
  </div>
  </div>
  @include("sweetalert::alert")
</body>

</html>
