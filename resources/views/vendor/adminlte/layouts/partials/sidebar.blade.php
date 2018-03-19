<aside class="main-sidebar">
    <section class="sidebar">
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar consolidado..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <ul class="sidebar-menu">
            <li class="header text-center">Menu de navegacion</li>
            <li><a href="{{ url('/') }}"><i class='fa fa-dashboard text-aqua'></i><span>Inicio</span></a></li>
            <li><a href="{{ route('profile') }}"><i class='fa fa-user-circle text-aqua'></i><span>Perfil</span></a></li>
            @if(Auth::user()->role_id == 1)
            <li><a href="{{ route('usuarios.index') }}"><i class='fa fa-users text-aqua'></i> <span>Usuarios</span></a></li>
            @endif
            {{-- <li><a href="{{ url('') }}"><i class='fa fa-send text-aqua'></i> <span>Nuevo envio</span></a></li> --}}
            <li><a href="{{ route('consolidados.index') }}"><i class='fa fa-arrows-h text-aqua'></i> <span>Administrar envios</span></a></li>
            {{-- <li><a href="{{ url('') }}"><i class='fa fa-cubes text-aqua'></i> <span>Consolidados</span></a></li> --}}
            {{-- <li><a href="{{ url('') }}"><i class='fa fa-cube text-aqua'></i> <span>Seguimiento</span></a></li> --}}
            
            {{-- <li class="treeview">
                <a href="#"><i class='fa fa-bar-chart text-red'></i> <span> Estadisticas</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                </ul>
            </li> --}}
        </ul>
    </section>
</aside>
