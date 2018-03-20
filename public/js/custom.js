"use strict";
toastr.options = {
	"closeButton": true,
	"newestOnTop": true,
	"positionClass": "toast-top-right",
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "5000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
}
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
	beforeSend: function (xhr) {
		xhr.setRequestHeader('Authorization');
	},
});
let translateTable = {
	sProcessing: 'Procesando...',
	sLengthMenu: 'Mostrar _MENU_ registros',
	sZeroRecords: 'No se encontraron resultados',
	sEmptyTable: 'Ningún dato disponible en esta tabla',
	sInfo: 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
	sInfoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
	sInfoFiltered: '(filtrado de un total de _MAX_ registros)',
	sInfoPostFix: '',
	sSearch: 'Buscar:',
	sUrl: '',
	sInfoThousands: ',',
	sLoadingRecords: 'Cargando...',
	oPaginate: {
		sFirst: 'Primero',
		sLast: 'Último',
		sNext: 'Siguiente',
		sPrevious: 'Anterior'
	},
	oAria: {
		sSortAscending: ': Activar para ordenar la columna de manera ascendente',
		sSortDescending: ': Activar para ordenar la columna de manera descendente'
	}
};
let messages = {
	'name': 'Nombres del usuario.',
	'last_name': 'Apellidos del usuario.',
	'phone': 'Telefono de contacto.',
	'email': 'Correo electronico.',
	'num_id': 'Documento de identidad.',
	'country_id': 'Pais de origen.',
	'city': 'Ciudad de origen.',
	'address': 'Direccion principal del usuario.',
	'address_two': 'Direccion secundaria del usuario.',
	'role_id': 'Rol del usuario.',
	'avatar': 'Imagen Personal.',
	'password2': 'Nueva contraseña.',
	'password2_confirmation': 'Repita nueva contraseña.',
};
let path = $('meta[name=url]')[0].content;
if (location.pathname == '/perfil') {
	// al cargar la pagina se colocan los inputs con readonly
	let inputs = $('form#profile').find('input, textarea, select');
	inputs.attr('disabled', '');
	$('#buttons_edit_perfil').hide();
	// se altera el estado de los inputs con este boton
	$('button#active_edit_profile, button#cancel').click(function (e) {
		e.preventDefault();
		restoreSmallInputs(messages)
		if ($(inputs[0]).attr('disabled') == undefined) {
			inputs.attr('disabled', '');
			$('#buttons_edit_perfil').fadeOut();
			UserProfile();
		} else {
			$('#buttons_edit_perfil').fadeIn();
			inputs.removeAttr('disabled');
		}
	});
	UserProfile();
	function UserProfile() {
		let id = $('form#profile')[0].action.split('/')[4];
		$.get(url+'/usuarios/'+id, 	function (response) {
			let option = '<option value="" selected disabled>Seleccione un pais.</option>';
			for (let i = 0; i < response.countries.length; i++) {
				let id = response.countries[i].id;
				let country = response.countries[i].country;
				option += '<option value="'+id+'">'+country+'</option>';
			}
			$('select#country_id').html(option);
			for (let i = 0; i < inputs.length; i++) {
				if (inputs[i].id) {
					let value = response.user[inputs[i].name];
					$(inputs[i]).val(value)
				}
			}
		});
	}
	// eventos al enviar el formulario del perfil
	$('form#profile').submit(function (e) {
		e.preventDefault();
		if ($(inputs[0]).attr('disabled') !== undefined) {
			toastr.warning("Debe activar la edición en el boton Editar Perfil!")
			return;
		}

		let url  = $(this).attr('action');
		let data = $(this).serializeArray();
		restoreSmallInputs(messages)
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: data,
		})
		.done(function(response) {
			toastr.success('Usuario editado exitosamente!');
			inputs.attr('disabled', '');
			$('#buttons_edit_perfil').hide();
			restoreSmallInputs(messages)
			UserProfile();
		})
		.fail(function(response) {
			mgs_errors(response.responseJSON)
		});
		if ($('input[name="avatar"]')[0].files[0]) {	
			$('#country_id').removeClass('text-danger')
			.text('Imagen Personal');
			let form = new FormData();
			let file = $('input[name="avatar"]')[0].files[0];
			form.append('avatar', file);
			let id = $('form#profile')[0].action.split('/')[4];
			axios
			.post(location.origin+'/save-image/'+id, form)
			.then(function (response) {
				toastr.success('Imagen editada con exito');
			})
			.catch(function (error) {
				$('#country_id').addClass('text-danger')
				.text(error.response.data.avatar[0])
			});
		}
	});
	// coloca un preview de la imagen subida
	$('input[name="avatar"]').change(function (e) {
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.readAsDataURL(this.files[0]);
			reader.onload = function (e) {
				$('div#avatar_profile img').attr({'src': e.target.result})
			}
		}
	});
}
// abrir el modal de cambio de password
$('#btn-change-pass').click(function (e) {
	$('form#change_password_form')[0].reset();
	$('div#change_password').modal('toggle');
});
// enviar los datos por ajax del cambio de password
$('form#change_password_form').submit(function (e) {
	e.preventDefault();
	let mgs_profile = {
		'old_password': 'Contraseña actual.',
		'password': 'Nueva contraseña.',
		'password_confirmation': 'Repita nueva contraseña.',
	}
	let url  = $(this).attr('action');
	let data = $(this).serializeArray();
	restoreSmallInputs(mgs_profile);
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: data,
	})
	.done(function(response) {
		toastr.success('Contraseña editada exitosamente!');
		$('div#change_password').modal('toggle');
		$('form#change_password_form')[0].reset();
	})
	.fail(function(response) {
		mgs_errors(response.responseJSON)
	});
});

function restoreSmallInputs(msg) {
	for (var i in msg) {
		$('small#'+i)
		.removeClass('text-danger')
		.addClass('text-muted')
		.text(msg[i]);
	}
}
function mgs_errors(msg) {
	for (var i in msg) {
		$('small#'+i)
		.addClass('text-danger')
		.text(msg[i][0]);
	}
	toastr.error('Ups, Al parecer ah ocurrido un error!');
	// console.clear();
}

if (location.pathname == '/usuarios') {
	$.get('get-data-user', function (response) {
		let option = '<option value="" selected disabled>Seleccione un pais.</option>';
		for (var i in response.countries) {
			option += '<option value="'+response.countries[i].id+'">'+response.countries[i].country+'</option>';
		}
		$('form#user_form').find('select#country_id').html(option);
		option = '<option value="" selected disabled>Seleccione un rol.</option>';
		for (var i in response.roles) {
			option += '<option value="'+response.roles[i].id+'">'+response.roles[i].rol+'</option>';
		}
		$('form#user_form').find('select#role_id').html(option);
	});
	let oTable = $('table#users-table').DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		render: true,
		language: translateTable,
		ajax: {
			url: location.origin + '/usuarios',
			complete: function () {
				$('input[type="radio"][name="user"]').click(function (){
					$('a[data-title="Edit"]').attr('id', $(this).val());
					$('a[data-title="Delete"]').attr('id', $(this).val());
				});
			}
		},
		"columns": [
		{
			data: 'action',
			name: 'action',
			searchable: false,
			sortable: false
		},
		{data: 'name', name: 'name'},
		{data: 'num_id', name: 'num_id'},
		{data: 'role.rol', name: 'role.id'},
		{data: 'email', name: 'email'},
		{data: 'country.country', name: 'country.id'},
		{data: 'phone', name: 'phone'},
		]
	});
	$('a[data-title="Delete"]').click(function (e) {
		e.preventDefault();
		if (!$(this).attr('id')) {
			toastr.warning('Debe seleccionar un usuario.');
			return;
		}
		let id = $(this).attr('id');
		let url = location.origin + '/usuarios/' + id;
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: {'_method': 'DELETE'}
		})
		.done(function(response) {
			toastr.success('Usuario Borrado exitosamente!');
			oTable.draw();
		})
		.fail(function(){
			toastr.success('Error al borrar usuario!');
		});
	});
	$('a[data-title="Edit"]').click(function (e) {
		e.preventDefault();
		if (!$(this).attr('id')) {
			toastr.warning('Debe seleccionar un usuario.');
			return;
		}
		let id = $(this).attr('id');
		let url = location.origin + '/usuarios/' + id;
		restoreSmallInputs(messages);
		$('form#user_form')[0].reset();
		$('#modal_user_form form')
		.attr('action', url)
		.find('input[name="_method"]')
		.attr('value', 'PUT');
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			for (var i in response.user) {
				$('form#user_form')
				.find('#'+i)
				.val(response.user[i]);
			}
			$('#modal_user_form')
			.modal('toggle')
			.find('h4.modal-title')
			.text('Editar Usuario: ' + response.user.name + ' ' + response.user.last_name + ' Sky.');
		})
		.fail(function(){
			toastr.success('Error al buscar usuario!');
		});
	})
	$('a#register_user').click(function () {
		$('#modal_user_form')
		.modal('toggle')
		.find('h4.modal-title')
		.text('Registrar Usuario.');
		restoreSmallInputs(messages);
		$('#modal_user_form form').attr('action', location.origin + '/usuarios/');
		$('#modal_user_form input[name="_method"]').attr('value', 'POST');
		$('form#user_form')[0].reset();
	});
	$('form#user_form').submit(function (e) {
		e.preventDefault();
		let url = $(this).attr('action');
		let func = $(this).find('input[name="_method"]')[0].value;
		let data = $(this).serializeArray();
		restoreSmallInputs(messages);
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: data,
		})
		.done(function(response) {
			oTable.draw();
			if (func == 'POST') {
				toastr.success('Usuario creado exitosamente!');
			} else {
				toastr.success('Usuario editado exitosamente!');
			}
			$('#modal_user_form').modal('toggle');
		})
		.fail(function(response) {
			mgs_errors(response.responseJSON)
		});
	})
}

if (location.pathname == '/consolidados') {
	$('div#header-search-a').hide();
	$('#search-cons-a').click(function (e) {
		e.preventDefault();
		$('div#header-search-a').fadeToggle();
	});
	$.post(path + 'data-for-consolidated', function (response) {
		let d = response.distributors;
		let option = '<option value="">Seleccione un repartidor</option>';
		for (let i in d) {
			option += '<option value="'+i+'">'+d[i]+'</option>';
		}
		$('select#distributor_id').html(option);
		let s = response.states;
		option = '<option value="">Seleccione un estado</option>';
		for (let i in s) {
			option += '<option value="'+i+'">'+s[i]+'</option>';
		}
		$('form#searchconsolidate select#status').html(option);
	});
	$('#addForm').click(function (e) {
		e.preventDefault();
		$(this).attr('disabled', '');
		setTimeout(() => {$(this).removeAttr('disabled');},1000);
		$.ajax({
			url: path + 'consolidados',
			type: 'POST',
			dataType: 'json',
			data: {
				index: 'create'
			}
		})
		.done(function(response) {
			trackTable.draw();
			$('.f-close').text(response.cierre);
			$('.f-create').text(response.creacion);
			$('form#tracking-form-register input#consolidated_id').val(response.id);
			consTable.draw();
			$('#modal-send-form').modal('toggle').find('.modal-title').html('<span class="fa fa-plus"></span> Crear Nuevo Consolidado.');
			toastr.success('Nuevo Consolidado Abierto');
		})
		.fail(function(response) {
			toastr.error('Opps al parecer a ocurrido un error');
		});
	});
	$('form#tracking-form-register').submit(function (e) {
		e.preventDefault();
		let url = $(this).attr('action');
		let data = $(this).serializeArray();
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: data
		})
		.done(function(response) {
			trackTable.draw();
			if (response.msg) {
				toastr.error(response.msg);
				return;
			}
			$('form#tracking-form-register')[0].reset();
			toastr.success('Tracking Registrado');
		})
		.fail(function(response) {
			toastr.error('Opps al parecer a ocurrido un error');
		});
	});
	var consTable = $('table#consolidated-a-table').DataTable({
		lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]],	
		processing: true,
		serverSide: true,
		responsive: true,
		render: true,
		language: translateTable,
		ajax: {
			url: path + 'consolidados',
			data: function (d) {
				d.consolidated = $('form#searchconsolidate input[name="consolidated"]').val();
				d.user = $('form#searchconsolidate input[name="user"]').val();
				d.close_date = $('form#searchconsolidate input[name="close_date"]').val();
				d.create_date = $('form#searchconsolidate input[name="create_date"]').val();
				d.status = $('form#searchconsolidate input[name="status"]').val();
			},
			complete: function () {
				$('input[type="radio"][name="consolidated"]').click(function () {
					let consolidated = $(this).val();
					$('button#deleteConsolidated, button#viewConsolidated, button#editConsolidated, button#extendConsolidated')
					.attr('consolidated', consolidated);
				});
			}
		},
		"columns": [
		{
			data: 'action',
			name: 'action',
			searchable: false,
			sortable: false
		},
		{data: 'number', name: 'number'},
		{data: 'fullname', name: 'user_id'},
		{data: 'created_at', name: 'created_at'},
		{data: 'cstate.state', name: 'cstate.state'},
		{data: 'close_at', name: 'close_at'},
		]
	});
	let trackTable = $('table#tracking-table').DataTable({
		lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]],	
		processing: true,
		serverSide: true,
		responsive: true,
		render: true,
		language: translateTable,
		ajax: {
			url: path + 'tracking',
			data: function (d) {
				d.consolidated_id = $('form#tracking-form-register input#consolidated_id').val();
			},
			complete: function () {
				$('a#deleteTracking').click(function () {
					let tracking = $(this).attr('tracking');
					$.post(path + 'tracking/' + tracking, {'_method': 'DELETE'}, function () {
						trackTable.draw();
						toastr.success('Tracking Eliminado.');
					});
				});
				$('a#editTracking').click(function () {
					let tracking = $(this).attr('tracking');
					$.get(path + 'tracking/' + tracking, function (response) {
						let entradas = $('form#tracking-form-register');
						for (let i in response) {
							entradas.find('input#'+i+', select#'+i).val(response[i])
						}
						$('#btn-create-tracking').hide();
						$('#btn-edit-tracking').removeClass('hidden')
						toastr.info('Editar Tracking.');
					});
				});
			}
		},
		"columns": [
		{data: 'distributor.name', name: 'trackings.distributor_id'},
		{data: 'tracking', name: 'trackings.id'},
		{data: 'description', name: 'trackings.description'},
		{
			data: 'action',
			searchable: false,
			sortable: false
		},
		]
	});
	$('form#searchconsolidate').submit(function (e) {
		e.preventDefault();
		consTable.draw();
	});
	$('button#deleteConsolidated').click(function () {
		let consolidated = $(this).attr('consolidated');
		if (consolidated === undefined) return;
		$.post(path + 'consolidados/' + consolidated, {'_method': 'DELETE'}, function () {
			consTable.draw();
			toastr.success('Consolidado Eliminado.');
		});
	})
}
