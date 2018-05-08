<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header text-center">Menu de navegacion</li>
            <li class="{!! Request::is('/') ? 'active' : '' !!}"><a href="{{ url('/') }}"><i class='fa fa-dashboard'></i><span>Inicio</span></a></li>
            <hr>
            <li class="{!! Request::is('perfil') ? 'active' : '' !!}"><a href="{{ route('profile') }}"><i class='fa fa-user-circle'></i><span>Perfil</span></a></li>
            <hr>
            @if(Auth::user()->role_id == 1)
            <li class="{!! Request::is('usuarios') ? 'active' : '' !!}"><a href="{{ route('usuarios.index') }}"><i class='fa fa-users'></i> <span>Usuarios</span></a></li>
            <hr>
            <li class="{!! Request::is('tracking') ? 'active' : '' !!}"><a href="{{ route('tracking.index') }}"><i class='fa fa-location-arrow'></i> <span>Administrar Trackings</span></a></li>
            <hr>
            @endif
            <li class="{!! Request::is('consolidados') ? 'active' : '' !!}"><a href="{{ route('consolidados.index') }}"><i class='fa fa-arrows-h'></i> <span>@if(Auth::user()->role_id == 1) Administrar @else Mis @endif envios</span></a></li>
            <hr>
        </ul>
    </section>
</aside>
