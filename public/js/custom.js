"use strict";
toastr.options = {
	"closeButton": true,
	"debug": true,
	"newestOnTop": true,
	"positionClass": "toast-top-right",
	"preventDuplicates": true,
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
	}
});

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
};
let url = location.origin;
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

		let form = new FormData();
		let file = $('input[name="avatar"]')[0].files[0];
		form.append('avatar', file);
		let id = $('form#profile')[0].action.split('/')[4];
		axios.post(location.origin+'/save-image/'+id, form)
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
	console.log('$("small#'+i+'")');
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
		language: {
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
		},
		ajax: {
			url: location.origin + '/usuarios',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: function (xhr) {
				xhr.setRequestHeader('Authorization');
			},
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
		{data: 'id', name: 'id'},
		{data: 'email', name: 'email'},
		{data: 'country_id', name: 'country_id'},
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
