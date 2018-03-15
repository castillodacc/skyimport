@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="box box-primary">
	<div class="box-header with-borders">
		<h3 class="box-title">Usuarios registrados</h3>
		<div class="pull-right">
			<div class="btn-group">
				<a class="btn btn-primary btn-xs" href="#" data-title="Edit" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Editar usuario"><span class="fa fa-edit"></span></a>
			</div>
			<div class="btn-group">
				<a class="btn btn-danger btn-xs" href="#" data-title="Delete" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Borrar usuario"><span class="glyphicon glyphicon-trash"></span></a>
			</div>
		</div>
	</div>
	<div id="users_table" class="box-body table-responsive">
		<table id="users-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center"><span class="fa fa-check-circle-o"></span> Elegir</th>
					<th><span class="fa fa-check-circle-user"></span> Usuario</th>
					<th><span class="fa fa-id-card"></span> Identificación</th>
					<th><span class="fa fa-hand-stop-o"></span> Rol</th>
					<th><span class="glyphicon glyphicon-envelope"></span> Correo</th>
					<th><span class="fa fa-globe"></span> Pais</th>
					<th><span class="fa fa-phone"></span> Telefono</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-center">
						<input type="radio" name="user" value="1">
					</td>
					<td>25196580</td>
					<td>Emanuel Surveyor Parra Coello</td>
					<td>Administrador</td>
					<td>ema_spc93@hotmail.com</td>
					<td>Colombia</td>
					<td>04146496795</td>
				</tr>
				<tr>
					<td class="text-center">
						<input type="radio" name="user" value="2">
					</td>
					<td>25196580</td>
					<td>Emanuel Surveyor Parra Coello</td>
					<td>Cliente</td>
					<td>ema_spc93@hotmail.com</td>
					<td>Colombia</td>
					<td>04146496795</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="box-footer">
		<a id="register_user" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Crear usuario"><span class="fa fa-plus"></span> Registrar usuario</a>
	</div>
</div>
@include('modals.user_form')
@endsection