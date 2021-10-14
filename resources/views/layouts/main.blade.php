<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonte do Google -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

        <!-- CSS Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

        <!-- CSS da aplicação -->
        <link rel="stylesheet" href="/css/styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="collapse navbar-collapse" id="navbar">
            <a href="/" class="navbar-brand">
              {{--<img src="/img/hdcevents_logo.svg" alt="HDC Events">--}}
            </a>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="/orcamentos/create" class="nav-link">Criar Orçamentos</a>
              </li>
              <li class="nav-item">
                <a href="/dashboard" class="nav-link">Orçamentos Existentes</a>
              </li>
              <li class="nav-item">
                <a href="/materiais/dashboard" class="nav-link">Materiais</a>
              </li>
              <li class="nav-item">
                <a href="/diarias/create" class="nav-link">Adicionar Diarias</a>
              </li>
              <li class="nav-item">
                <a href="/equipes/create" class="nav-link">Adicionar Profissionais</a>
              </li>
              <li class="nav-item">
                <form action="/logout" method="POST">
                  @csrf
                  <a href="/logout" class="nav-link" 
                    onclick="event.preventDefault();
                      this.closest('form').submit();">
                      Sair
                  </a>
                </form>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <main>
        <div class="container-fluid">
          @if(session('msg'))
            <p class="msg">{{ session('msg') }}</p>
          @endif
          @yield('content')
        </div>
      </main>
      <footer>
        <p>CRM Health Clin &copy; 2021</p>
      </footer>
      <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
      <script src="/js/scripts.js"></script>
    </body>
</html>
