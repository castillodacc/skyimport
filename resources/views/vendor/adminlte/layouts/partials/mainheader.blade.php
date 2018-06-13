<!-- Main Header -->
<header class="main-header">
  <!-- Logo -->
  <a href="{{ url('/home') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="/img/skyimportnavmini.png"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="/img/skyimportglobal.png" width="180px" height="55px"></span>
  </a>
  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        @if (Auth::guest())
        <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
        <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
        @else
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span id="notifications_total" class="label label-warning"></span>
          </a>
          <ul id="notifications" class="dropdown-menu"></ul>
        </li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ Auth::user()->pathAvatar() }}" class="user-image" alt="Imagen de usuario">
            <span class="hidden-xs">{{ Auth::user()->fullName() }}</span>
            <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li class="user-body">
                <a href="#" id="btn-change-pass"><span class="fa fa-cogs"></span> Cambiar contraseña</a>
                <div class="divider"></div>
                <a href="{{ url('/logout') }}"  id="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="fa fa-sign-out"></span> Cerrar sesion</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                  <input type="submit" value="logout" style="display: none;">
                </form>
              </li>
            </ul>
          </li>
          @endif
        </ul>
      </div>
    </nav>
  </header>
