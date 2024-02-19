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

  <!-- Style -->
  <link rel="stylesheet" href="{{ asset("css/styles.css") }}">

  <!-- Scripts -->
  @vite(["resources/sass/app.scss", "resources/js/app.js"])
</head>

<body>
  <div id="app">
    <div class="background-home">
      <nav class="navbar navbar-expand-md navbar-light nav-bg shadow-sm py-0">
        <div class="container">
          <a class="navbar-brand" href="{{ url("/") }}">
            <img src="{{ asset("img/Logo.png") }}" id="brand-img" alt="Logo de um carro vermelho" />
          </a>
          <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __("Toggle navigation") }}">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
              <!-- Authentication Links -->
              @guest
                @if (Route::currentRouteName() === "login")
                  <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route("register") }}">Registrar</a>
                  </li>
                @else
                  <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route("login") }}">Login</a>
                  </li>
                @endif
              @else
                <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                  </a>

                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route("logout") }}"
                      onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                      {{ __("Logout") }}
                    </a>

                    <form id="logout-form" action="{{ route("logout") }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </div>
                </li>
              @endguest
            </ul>
          </div>
        </div>
      </nav>

      <main class="py-4 app-main">
        @yield("content")
      </main>
      <footer>
        <nav>
          <div class="links-footer">
            <a href="https://www.linkedin.com/in/euzebio-batista/" class="link-footer">
              <i class="fa-brands fa-linkedin text-primary"></i> Linkedin
            </a>
            <a href="https://portfolio-euzebiobatista.vercel.app" class="link-footer">
              <i class="fa-solid fa-user-tie text-info-emphasis"></i> Portfolio
            </a>
            <a href="https://github.com/EuzebioBatista2" class="link-footer">
              <i class="fa-brands fa-github git-icon"></i> GitHub
            </a>
          </div>
        </nav>
        <hr />
        <p>Euzebio Batista &copy; 2024.</p>
      </footer>
    </div>
  </div>
</body>

</html>
