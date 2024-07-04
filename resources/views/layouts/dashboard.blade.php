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

  <!-- Select2 + jQuery + Moment --->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>

  <!-- Graph -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <div id="app">
    <div class="container-fluid background-page" style="height: 100vh;">
      <main class="row h-100" style="position: relative">
        <aside class="h-100" id="menu-bar">
          <button id="toggle-button"><i class="fa-solid fa-chevron-left"></i></button>
          <div class="brand-div">
            <img src="{{ asset("img/Logo.webp") }}" alt="Logo de um carro vermelho" class="img-brand-dash">
          </div>
          <div class="container-auth">
            <div class="menu-link w-100 principal-link">
              <h3 class="auth-name text-capitalize">{{ Auth::user()->name }}</h3>
              <hr class="line my-1" />
              <nav class="links">
                <a href="{{ route("dashboard") }}"
                  @if (Route::currentRouteName() === "dashboard") class="text-white link-dash link-disabled" onclick="return false;" @else class="link-gray link-dash" @endif>
                  <i class="fa-solid fa-house"></i> DASHBOARD
                </a>
                <a href="{{ route("customers") }}"
                  @if (Route::currentRouteName() === "customers") class="text-white link-dash link-disabled" onclick="return false;" @else class="link-gray link-dash" @endif>
                  <i class="fa-solid fa-user link-dash"></i> CLIENTES
                </a>
                <a href="{{ route("vehicles") }}"
                  @if (Route::currentRouteName() === "vehicles") class="text-white link-dash link-disabled" onclick="return false;" @else class="link-gray link-dash" @endif>
                  <i class="fa-solid fa-car link-dash"></i> VEÍCULOS
                </a>
                <a href="{{ route("reviews") }}"
                  @if (Route::currentRouteName() === "reviews") class="text-white link-dash link-disabled" onclick="return false;" @else class="link-gray link-dash" @endif>
                  <i class="fa-solid fa-address-book link-dash"></i> REVISÕES
                </a>

                <a href="{{ route("account") }}"
                  @if (Route::currentRouteName() === "account") class="text-white link-dash link-disabled" onclick="return false;" @else class="link-gray link-dash" @endif>
                  <i class="fa-solid fa-user-tie"></i></i> CONTA
                </a>
              </nav>
            </div>
            <div class="menu-link w-100 secondary-link">
              <nav class="links">
                <form action="{{ route("logout") }}" method="POST">
                  @csrf
                  <button type="submit" class="link-dash link-gray">
                    <i class="fa-solid fa-right-from-bracket link-dash"></i> SAIR
                  </button>
                </form>
              </nav>
            </div>
          </div>
        </aside>
        <section class="col-12 content-all">
          @yield("content")
        </section>
      </main>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {

      /* Nav_bar */
      let menu_bar = document.getElementById("menu-bar");

      /* Items */
      let brand = document.querySelector(".brand-div");
      let principal_link = document.querySelector(".principal-link");
      let secondary_link = document.querySelector(".secondary-link");

      /* Icon */
      let icon = document.querySelector("#toggle-button i");

      document.getElementById("toggle-button").addEventListener("click", function(event) {

        event.stopPropagation();

        if (menu_bar.style.width === "0px") {
          menu_bar.style.width = "260px";
          icon.classList.remove("fa-chevron-right");
          icon.classList.add("fa-chevron-left");
          let time_out_id = setTimeout(function() {
            brand.style.display = "flex"
            principal_link.style.display = "flex"
            secondary_link.style.display = "flex"
            clearTimeout(time_out_id);
          }, 500);

          document.querySelector(".content-all").addEventListener("click", function() {
            menu_bar.style.width = "0px";
            brand.style.display = "none"
            principal_link.style.display = "none"
            secondary_link.style.display = "none"

            icon.classList.remove("fa-chevron-left");
            icon.classList.add("fa-chevron-right");
          }, {
            once: true
          });
        } else {
          menu_bar.style.width = "0px";
          brand.style.display = "none"
          principal_link.style.display = "none"
          secondary_link.style.display = "none"

          icon.classList.remove("fa-chevron-left");
          icon.classList.add("fa-chevron-right");
        }
      });

      document.querySelector(".content-all").addEventListener("click", function() {
        menu_bar.style.width = "0px";
        brand.style.display = "none"
        principal_link.style.display = "none"
        secondary_link.style.display = "none"

        icon.classList.remove("fa-chevron-left");
        icon.classList.add("fa-chevron-right");
      }, {
        once: true
      });
    });
  </script>
  @include("sweetalert::alert")
</body>

</html>
