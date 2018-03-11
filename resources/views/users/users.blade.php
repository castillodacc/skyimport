@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="box box-primary">
	<div class="box-header">
		<a id="register_user" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Crear usuario"><span class="fa fa-plus"></span> Registrar usuario</a>
		<div class="pull-right">
			<div class="btn-group">
				<a class="btn btn-primary btn-xs" href="#" data-title="Edit" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Editar usuario"><span class="glyphicon glyphicon-pencil"></span></a>
			</div>
			<div class="btn-group">
				<a class="btn btn-danger btn-xs" href="#" data-title="Delete" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Borrar usuario"><span class="glyphicon glyphicon-trash"></span></a>
			</div>
		</div>
	</div>
	<div id="users_table" class="box-body">
		<table id="users-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center">Elegir</th>
					<th>Usuario</th>
					<th>N° de Identificación</th>
					<th>Rol</th>
					<th>Correo</th>
					<th>Pais</th>
					<th>Telefono</th>
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
</div>
@include('modals.user_form')
@endsection