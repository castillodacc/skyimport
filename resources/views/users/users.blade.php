@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Usuarios registrados</h3>
	</div>
	<div id="users_table" class="box-body table-responsive">
		<div class="col-md-12">
			<table id="users-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><span class="fa fa-user-circle"></span> Usuario</th>
					<th><span class="fa fa-id-card"></span> Identificación</th>
					<th width="100px"><span class="fa fa-hand-stop-o"></span> Rol</th>
					<th><span class="glyphicon glyphicon-envelope"></span> Correo</th>
					<th><span class="fa fa-globe"></span> Pais</th>
					<th><span class="fa fa-phone"></span> Telefono</th>
					<th><span class="fa fa-check-circle-o"></span> Acciones</th>
				</tr>
			</thead>
		</table>
		</div>
	</div>
	<div class="box-footer">
		<a id="register_user" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Crear usuario"><span class="fa fa-plus"></span> Registrar usuario</a>
	</div>
</div>
@include('modals.user_form')
@endsection