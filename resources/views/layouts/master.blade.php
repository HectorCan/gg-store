<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/bootstrap-material-design.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/sidebarjs/sidebarjs.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/fontawesome/css/all.min.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <span>
        <button id="sidebar-toggle" class="btn btn-sm" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" style="margin-right: 0px;" href="{{ url('/') }}">
          {{ config('app.name', 'GG-STORE') }}
        </a>
      </span>
      <div id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
            @endif
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <div class="row" style="margin: 0px;">
    <div id="sidebar-left" class="col sidebar" style="max-width: 250px; padding: 0px;">
      <div class="card" style="height: 100%;">
        <div class="card-body" style="overflow-y: auto;">
          Menu
        </div>
      </div>
    </div>
    <div class="col" style="padding: 0px;">
      <main class="py-4">
        @yield('content')
      </main>
    </div>
  </div>
</div>

<script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/sidebarjs/sidebarjs.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/fontawesome/css/all.min.js') }}" type="text/javascript"></script>

<script>
  function fixSize() {
    var h = $(window).height() - 58.2;
    $('.sidebar').css('height', h);
  }

  $(document).ready(function () {
    fixSize();

    $('#sidebar-toggle').click(function () {
      var ls = $('#sidebar-left');
    });
  });

  $(window).resize(function () {
    fixSize();
  });
</script>
@yield('scripts')
</body>
</html>
