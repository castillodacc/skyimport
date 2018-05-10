@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<i class="box-title">Usuarios registrados</i>
		 <div class="pull-right">
            <div class="btn-group btn-group-xs">
                <button type="button" class="btn btn-box-tool btn-flat" data-widget="collapse"><i class="fa fa-minus"></i>
                </button> 
            </div>
        </div>
	</div>
	<div id="users_table" class="box-body table-responsive">
		<div class="col-md-12">
			<table id="users-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="25%">Usuario</th>
					<th>Identificación</th>
					<th width="5%">Rol</th>
					<th>Correo</th>
					<th>Pais</th>
					<th>Telefono</th>
					<th class="text-center" width="20%">Acciones</th>
				</tr>
			</thead>
		</table>
		</div>
	</div>
	<div class="box-footer">
		<a id="register_user" class="btn btn-primary btn-sm btn-flat"><span class="fa fa-plus"></span> Registrar usuario</a>
	</div>
</div>
@include('modals.user_form')
@endsection