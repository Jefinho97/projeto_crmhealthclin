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
        <!-- <meta name="csrf-token" content="{{ csrf_token() }}" /> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="/js/scripts.js"></script>
        
    </head>
    <body>
      
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
    </body>
</html>
