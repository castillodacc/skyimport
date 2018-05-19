$('.date').datepicker({
	format: "yyyy-mm-dd",
	todayBtn: true,
	clearBtn: true,
	language: "es",
	orientation: "bottom auto",
	autoclose: true,
	todayHighlight: true
});
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
	'state_id': 'Estado o Departamento.',
	'password2': 'Nueva contraseña.',
	'password2_confirmation': 'Repita nueva contraseña.',
};
let path = $('meta[name=url]')[0].content;
$('.notifications-menu').click(function () {
	let total = $('#notifications_total').text();
	if (total != 0) {
		$.post(path + 'notifications-view', function (response) {
			$('#notifications_total').html('0');
		});
	}
});
$.ajax({
	url: path + 'notifications',
	type: 'POST',
	dataType: 'json',
})
.done(function(response) {
	$('ul#notifications').html(response.html)
	$('#notifications_total').html(response.notifications_total)
	$('li#notification').click(function () {
		let consolidated = $(this).attr('consolidated');
		$('table#table-view-trackings').attr('consolidated', consolidated);
		let url = path + 'consolidados/' + consolidated;
		$.get(url, function (response) {
			let modal = $('div#modal-send-show');
			modal.find('.modal-title').html('<span class="fa fa-cube"></span> Consolidado n° ' + response.number);
			modal.find('td#number').text(response.number);
			modal.find('td#user').text(response.user.name + ' ' + response.user.last_name);
			modal.find('td#created_date').text(response.open);
			modal.find('td#closed_date').text(response.close);
			if (response.bill > 0) {
				modal.find('td#bill').text(number_format(response.bill, 2) + ' COP').addClass('success');
				modal.find('td#weight').text(number_format(response.weight, 2) + ' Lb').addClass('success');
			} else {
				modal.find('td#bill').removeClass('success').text(response.bill);
				modal.find('td#weight').removeClass('success').text(response.weight);
			}
			modal.find('td#state').html(response.event);
			modal.find('td#cant').text(response.trackings.length);
			modal.find('td#value').text(response.sum_total + ' USD');
			trackTableView.draw();
			modal.modal('toggle');
		});
	});
})
.fail(function(response) {
	toastr.error('Error al cargar notificaciones');
});
let translateTableCustom = translateTable;
translateTableCustom.sInfoFiltered = '';
var trackTableView = $('table#table-view-trackings').DataTable({
	processing: true,
	serverSide: true,
	searching: false,
	responsive: true,
	language: translateTableCustom,
	ajax: {
		url: path + 'tracking',
		data: function (d) {
			d.consolidated_id = $('table#table-view-trackings').attr('consolidated');
		}
	},
	columns: [
	{data: 'distributor.name', name: 'trackings.distributor_id'},
	{data: 'tracking', name: 'trackings.id'},
	{data: 'description', name: 'trackings.description'},
	{data: 'price', name: 'trackings.price'},
	{data: 'created_at', name: 'created_at'},
	{data: 'shippingstate_id', name: 'shippingstate_id'},
	]
});
function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

    return amount_parts.join(',');
}
if (location.href.indexOf('/perfil') > 0) {
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
	$.get(path + 'usuarios/'+id, function (response) {
		let option = '<option value="" selected disabled>Seleccione un pais.</option>';
		let countries = response.countries;
		for (let i in countries) {
			option += '<option value="'+i+'">'+countries[i]+'</option>';
		}
		let user = response.user;
		$('select#country_id').html(option)
		$('a#sin-form').text(user.consolidateda);
		$('a#form').text(user.consolidatedc);
		if (user.state) {
			$('select#country_id').val(user.state.countrie_id);
			$.get(path + 'get-data-states/' + user.state.countrie_id, function (response) {
				if (user.country_id == 1) {
					option = '<option value="">Seleccione un Departamento</option>';
				} else {
					option = '<option value="">Seleccione un Estado</option>';
				}
				for (let i in response) {
					option += '<option value="'+i+'">'+response[i]+'</option>';
				}
				$('select#state_id').html(option);
				for(let i in inputs) {
					if (inputs[i].id && inputs[i].id != 'country_id') {
						let value = user[inputs[i].name];
						$(inputs[i]).val(value);
					}
				}
			});
		} else {
			for(let i in inputs) {
				if (inputs[i].id && inputs[i].id != 'country_id') {
					let value = user[inputs[i].name];
					$(inputs[i]).val(value);
				}
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
		$('#avatar').removeClass('text-danger')
		.text('Imagen Personal');
		let form = new FormData();
		let file = $('input[name="avatar"]')[0].files[0];
		form.append('avatar', file);
		let id = $('form#profile')[0].action.split('/')[4];
		axios
		.post(path+'save-image/'+id, form)
		.then(function (response) {
			toastr.success('Imagen editada con exito');
		})
		.catch(function (error) {
			$('#avatar').addClass('text-danger')
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
if (location.href.indexOf('/usuarios') > 0 || location.href.indexOf('/perfil') > 0) {
	$('select#country_id').change(function (e) {
		let num = $(this).val();
		let option;
		$.get(path + 'get-data-states/' + num, function (response) {
			if (num == 1) {
				option = '<option value="">Seleccione un Departamento</option>';
			} else {
				option = '<option value="">Seleccione un Estado</option>';
			}
			for (let i in response) {
				option += '<option value="'+i+'">'+response[i]+'</option>';
			}
			$('select#state_id').html(option);
		});
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
	console.clear();
}
if (location.href.indexOf('/usuarios') > 0) {
	$.get('get-data-user/', function (response) {
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
	var oTable = $('table#users-table').DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		render: true,
		language: translateTable,
		ajax: {
			url: path + 'usuarios',
			complete: function () {
				let tr = $('tr');
				for (var i = 0; i <= tr.length; i++) {
					let t = tr[i];
					let td = $(t).children('td')[2];
					let text = $(td).text();
					$(td).html(text);
				}
				$('button#edit-user').click(function (e) {
					e.preventDefault();
					let id = $(this).attr('user');
					let url = path + 'usuarios/' + id;
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
						if (response.user.state) {
							let countrie = response.user.state.countrie_id;
							let state = response.user.state.id;
							let option;
							$('select#country_id').val(countrie);
							$.get(path + 'get-data-states/' + countrie, function (response) {
								if (countrie == 1) {
									option = '<option value="">Seleccione un Departamento</option>';
								} else {
									option = '<option value="">Seleccione un Estado</option>';
								}
								for (let i in response) {
									option += '<option value="'+i+'">'+response[i]+'</option>';
								}
								$('select#state_id').html(option).val(state);
							});
						}
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
				});
				$('button#delete-user').click(function (e) {
					let id = $(this).attr('user');
					let tr = $(this).parent().parent().parent();
					let url = path + 'usuarios/' + id;
					$.ajax({
						url: url,
						type: 'POST',
						dataType: 'json',
						data: {'_method': 'DELETE'}
					})
					.done(function(response) {
						toastr.success('Usuario Borrado exitosamente!');
						tr.html('<td colspan="7" class="text-center"> Usuario Eliminado con éxito. <a href="#" id="restore-user" user="'+id+'">Restaurar</a> | <a href="#" id="no-restore">Continuar</a></td>');
						$('a#restore-user').click(function (e) {
							e.preventDefault();
							let user = $(this).attr('user');
							$.post(path + 'usuarios/restore/' + user, function () {
								toastr.success('Usuario Restaurado');
								oTable.draw();
							});
						});
						$('a#no-restore').click(function (e) {
							e.preventDefault();
							oTable.draw();
						});
					})
					.fail(function(){
						toastr.success('Error al borrar usuario!');
					});
				});
			}
		},
		order: [[0, 'DESC']],
		columns: [
		{data: 'fullname', name: 'name'},
		{data: 'num_id', name: 'num_id'},
		{data: 'role.rol', name: 'role_id'},
		{data: 'email', name: 'email'},
		{data: 'pais', name: 'state_id'},
		{data: 'phone', name: 'phone'},
		{data: 'action', name: 'action', orderable: false, searchable: false}
		]
	});
	$('a#register_user').click(function () {
		$('#modal_user_form')
		.modal('toggle')
		.find('h4.modal-title')
		.text('Registrar Usuario.');
		restoreSmallInputs(messages);
		$('#modal_user_form form').attr('action', path + 'usuarios/');
		$('#modal_user_form input[name="_method"]').attr('value', 'POST');
		$('select#state_id').html('<option value="">Seleccione primero un pais.</option>');
		$('form#user_form')[0].reset();
	});
	$('form#user_form').submit(function (e) {
		e.preventDefault();
		let url = $(this).attr('action');
		if ($(this).attr('action') == path + 'usuarios/') {
			url = $(this).attr('action').substring(0, url.length-1);
		} else {
			url = $(this).attr('action');
		}
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
if (location.href.indexOf('/consolidados') > 0) {
	$('div#header-search-a').hide();
	$('#search-cons-a').click(function (e) {
		e.preventDefault();
		$('div#header-search-a').fadeToggle();
	});
	$('button#cancel-consolidated').click(function () {
		let id = $('form#tracking-form-register input#consolidated_id')[0].value;
		$.post(path + 'consolidados/'+id, {'_method':'DELETE'}, function (response) {
			consTable.draw();
			$('#modal-send-form').modal('toggle');
			toastr.success('Consolidado Cancelado.');
		});
	});
	$.post(path + 'data-for-consolidated', function (response) {
		let d = response.distributors;
		let option = '<option value="">Repartidor</option>';
		for (let i in d) {
			option += '<option value="'+d[i].id+'">'+d[i].name+'</option>';
		}
		$('select#distributor_id').html(option);
	});
	var consTable = $('table#consolidated-a-table').DataTable({
		lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]],	
		processing: true,
		serverSide: true,
		searching: false,
		responsive: true,
		render: true,
		language: translateTable,
		ajax: {
			url: path + 'consolidados',
			data: function (d) {
				d.consolidated = $('form#searchconsolidate input[name="consolidated"]').val();
				d.close_date = $('form#searchconsolidate input[name="close_date"]').val();
				d.create_date = $('form#searchconsolidate input[name="create_date"]').val();
				d.c = 'abierto';
			},
			complete: function () {
				$('[data-toggle="tooltip"]').tooltip();
				let tr = $('table#consolidated-a-table tr');
				for (var i = 0; i <= tr.length; i++) {
					let t = tr[i];
					let td = $(t).children('td');
					let text = $(td[3]).text();
					$(td[3]).html(text);
				}
				$('button#extendConsolidated').click(function () {
					let consolidated = $(this).attr('consolidated');
					let url = path + 'extend-consolidated/' + consolidated;
					$.ajax({
						url: url,
						type: 'POST',
						dataType: 'json',
					})
					.done(function(response) {
						if (response.msg) {
							toastr.info(response.msg);
							return;
						}
						consTable.draw();
						toastr.success('Consolidado Extendido un día.');
					})
					.fail(function(response) {
						toastr.error('Opps al parecer a ocurrido un error');
					});
				});
				$('button#viewConsolidated').click(function (e) {
					e.preventDefault();
					let consolidated = $(this).attr('consolidated');
					$('table#table-view-trackings').attr('consolidated', consolidated);
					let url = path + 'consolidados/' + consolidated;
					$.get(url, function (response) {
						let modal = $('div#modal-send-show');
						modal.find('.modal-title').html('<span class="fa fa-cube"></span> Consolidado n° ' + response.number);
						modal.find('td#number').text(response.number);
						modal.find('td#user').text(response.user.name + ' ' + response.user.last_name);
						modal.find('td#created_date').text(response.open);
						modal.find('td#closed_date').text(response.close);
						modal.find('td#state').text(response.event);
						modal.find('td#cant').text(response.trackings.length);
						modal.find('td#value').text(new Intl.NumberFormat("de-DE", {style: "currency", currency: "USD"}).format(response.sum_total));
						if (response.bill > 0) {
							modal.find('td#bill').text(number_format(response.bill, 2) + ' COP').addClass('success');
							modal.find('td#weight').text(number_format(response.weight, 2) + ' Lb').addClass('success');
						} else {
							modal.find('td#bill').removeClass('success').text(response.bill);
							modal.find('td#weight').removeClass('success').text(response.weight);
						}
						trackTableView.draw();
						modal.modal('toggle');
					});
				});
				$('button#editConsolidated').off('click');
				$('button#editConsolidated').click(function () {
					let consolidated = $(this).attr('consolidated');
					let url = path + 'consolidados/' + consolidated;
					$.get(url, function (response) {
						$('tr').removeClass('info');
						$('#btn-create-tracking').show();
						$('#btns-edit-tracking').hide();
						$('#tracking-form-register input[name=_method]').val('POST');
						$('#tracking-form-register').attr('action', path + 'tracking');
						$('.f-close').text(response.close);
						$('.f-create').text(response.open);
						$('input[name="user_id"]').val(response.user.name + ' ' + response.user.last_name + ((response.user.num_id) ? ' / ' + response.user.num_id : ''));
						$('form#tracking-form-register input#consolidated_id').val(response.id);
						$('#modal-send-form').modal('toggle').find('.modal-title').html('<span class="fa fa-edit"></span> Editar Consolidado ' + response.number);
						trackTable.draw();
					});
				});
				$('button#deleteConsolidated').click(function () {
					let id = $(this).attr('consolidated');
					let tr = $(this).parent().parent().parent();
					let url = path + 'consolidados/' + id;
					$.ajax({
						url: url,
						type: 'POST',
						dataType: 'json',
						data: {'_method': 'DELETE'}
					})
					.done(function(response) {
						toastr.success('Consolidado borrado exitosamente!');
						tr.html('<td colspan="7" class="text-center"> Consolidado eliminado con exito. <a href="#" id="restore-consolidated" consolidated="'+id+'">Restaurar</a> | <a href="#" id="no-restore">Continuar</a></td>');
						$('a#restore-consolidated').click(function (e) {
							e.preventDefault();
							let consolidated = $(this).attr('consolidated');
							$.post(path + 'consolidados/restore/' + consolidated, function () {
								toastr.success('Consolidado restaurado');
								consTable.draw();
							});
						});
						$('a#no-restore').click(function (e) {
							e.preventDefault();
							consTable.draw();
						});
					})
					.fail(function(){
						toastr.success('Error al borrar usuario!');
					});
				});
			}
		},
		order: [[2, 'DESC']],
		columns: [
		{data: 'number', name: 'number'},
		{data: 'fullname', name: 'user_id'},
		{data: 'created_at', name: 'created_at'},
		{data: 'shippingstate', name: 'shippingstate_id'},
		{data: 'num_trackings', orderable: false, searchable: false},
		{data: 'closed_at', name: 'closed_at'},
		{data: 'action', orderable: false, searchable: false}
		]
	});
	var trackTable = $('table#tracking-table').DataTable({
		processing: true,
		serverSide: true,
		searching: false,
		responsive: true,
		render: true,
		language: translateTableCustom,
		ajax: {
			url: path + 'tracking',
			data: function (d) {
				d.consolidated_id = $('form#tracking-form-register input#consolidated_id').val();
			},
			complete: function () {
				$('a#deleteTracking').click(function () {
					let tracking = $(this).attr('tracking');
					$('form#tracking-form-register')[0].reset();
					$('#tracking-form-register input[name=_method]').val('POST');
					$('form#tracking-form-register').attr('action', path + 'tracking');
					$('#btn-create-tracking').show();
					$('#btns-edit-tracking').hide();
					$.post(path + 'tracking/' + tracking, {'_method': 'DELETE'}, function () {
						trackTable.draw();
						toastr.success('Tracking Eliminado.');
					});
				});
				$('a#editTracking').click(function () {
					let tracking = $(this).attr('tracking');
					$('tr').removeClass('info');
					$(this).parent().parent().parent().addClass('info')
					$.get(path + 'tracking/' + tracking, function (response) {
						let entradas = $('form#tracking-form-register');
						for (let i in response) {
							entradas.find('input#'+i+', select#'+i).val(response[i])
						}
						$('#btn-create-tracking').hide();
						$('#btns-edit-tracking').show();
						$('#btns-edit-tracking').removeClass('hidden');
						$('#tracking-form-register input[name=_method]').val('PUT');
						$('#tracking-form-register').attr('action', path + 'tracking/' + tracking);
						toastr.info('Editar Tracking.');
					});
				});
			}
		},
		columns: [
		{data: 'distributor.name', name: 'trackings.distributor_id'},
		{data: 'tracking', name: 'trackings.id'},
		{data: 'description', name: 'trackings.description'},
		{data: 'action', searchable: false, sortable: false},
		]
	});
	var consTable2 = $('table#consolidated-b-table').DataTable({
		lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]],	
		processing: true,
		autoWidth: false,
        searching: false,
		serverSide: true,
		responsive: true,
		render: true,
		language: translateTable,
		ajax: {
			url: path + 'consolidados',
			data: function (d) {
				d.consolidated = $('form#search-consolidate-formalized input[name="consolidated_formalized"]').val();
				d.close_date = $('form#search-consolidate-formalized input[name="closed_at"]').val();
				d.create_date = $('form#search-consolidate-formalized input[name="created_at"]').val();
				d.c = 'cerrado';
			},
			complete: function () {
				let tr = $('#consolidated-b-table tr');
				for (var i = 0; i <= tr.length; i++) {
					let t = tr[i];
					let td = $(t).children('td');
					let text = $(td[3]).text();
					$(td[3]).html(text);
				}
				$('button#extendConsolidated').click(function () {
					let consolidated = $(this).attr('consolidated');
					let url = path + 'extend-consolidated/' + consolidated;
					$.ajax({
						url: url,
						type: 'POST',
						dataType: 'json',
					})
					.done(function(response) {
						if (response.msg) {
							toastr.info(response.msg);
							return;
						}
						consTable.draw();
						consTable2.draw();
						toastr.success('Consolidado Extendido un día.');
					})
					.fail(function(response) {
						toastr.error('Opps al parecer a ocurrido un error');
					});
				});
				$('button#editEventConsolidated').click(function () {
					let consolidated = $(this).attr('consolidated');
					let event = $(this).attr('event');
					let data = {
						consolidated: consolidated,
						event: event,
					}
					$.post(path + 'add-event', data, function (response) {
						consTable2.draw();
						toastr.success('Cambio de estado Exitoso');
					});
				});
				$('button#editConsolidated').off('click');
				$('button#editConsolidated').click(function () {
					let consolidated = $(this).attr('consolidated');
					let url = path + 'consolidados/' + consolidated;
					$.get(url, function (response) {
						$('tr').removeClass('info');
						$('#btn-create-tracking').show();
						$('#btns-edit-tracking').hide();
						$('#tracking-form-register input[name=_method]').val('POST');
						$('#tracking-form-register').attr('action', path + 'tracking');
						$('.f-close').text(response.close);
						$('.f-create').text(response.open);
						$('input[name="user_id"]').val(response.user.name + ' ' + response.user.last_name + ((response.user.num_id) ? ' / ' + response.user.num_id : ''));
						$('form#tracking-form-register input#consolidated_id').val(response.id);
						$('#modal-send-form').modal('toggle').find('.modal-title').html('<span class="fa fa-edit"></span> Editar Consolidado ' + response.number);
						trackTable.draw();
					});
				});
				$('button#view-formalized').click(function (e) {
					e.preventDefault();
					let consolidated = $(this).attr('consolidated');
					$('table#table-view-trackings').attr('consolidated', consolidated);
					let url = path + 'consolidados/' + consolidated;
					$.get(url, function (response) {
						let modal = $('div#modal-send-show');
						modal.find('.modal-title').html('<span class="fa fa-cube"></span> Consolidado n° ' + response.number);
						modal.find('td#number').text(response.number);
						modal.find('td#user').text(response.user.name + ' ' + response.user.last_name);
						modal.find('td#created_date').text(response.open);
						modal.find('td#closed_date').text(response.close);
						modal.find('td#state').html(response.event);
						if (response.bill > 0) {
							modal.find('td#bill').text(number_format(response.bill, 2) + ' COP').addClass('bg-success');
							modal.find('td#weight').text(number_format(response.weight, 2) + ' Lb').addClass('bg-success');
						} else {
							modal.find('td#bill').text(response.bill).removeClass('success');
							modal.find('td#weight').text(response.weight).removeClass('success');
						}
						modal.find('td#cant').text(response.trackings.length);
						modal.find('td#value').text(response.sum_total + ' USD');
						trackTableView.draw();
						modal.modal('toggle');
					});
				});
				$('button#edit-formalized').click(function (e) {
					e.preventDefault();
					let consolidated = $(this).attr('consolidated');
					$('table#table-edit-formalized').attr('consolidated', consolidated);
					$('table#table-edit-formalized tbody').html('')
					cargarEventos(consolidated);
					$('button#agregar-event').attr('consolidated', consolidated);
					trackTable2.draw();
					setTimeout(function () {$('#modal-send_formalizated_edit').modal('toggle'); },350);
				});
				$('button#delete-formalized').click(function (e) {
					e.preventDefault();
					let consolidated = $(this).attr('consolidated');
					let tr = $(this).parent().parent().parent();
					$.post(path + 'consolidados/' + consolidated, {'_method': 'DELETE'}, function () {
						toastr.success('Consolidado Borrado!');
						tr.html('<td colspan="7" class="text-center"> Consolidado Eliminado con exito. <a href="#" id="restore-consolidated" consolidated="'+consolidated+'"> Restaurar</a> | <a href="#" id="no-restore">Continuar</a></td>');
						$('a#restore-consolidated').click(function (e) {
							e.preventDefault();
							let consolidated = $(this).attr('consolidated');
							$.post(path + 'consolidados/restore/' + consolidated, function () {
								toastr.success('Consolidado restaurado');
								consTable2.draw();
							});
						});
						$('a#no-restore').click(function (e) {
							e.preventDefault();
							consTable2.draw();
						});
					});
				});
				$('button#factureConsolidated').click(function () {
					let consolidated = $(this).attr('consolidated');
					let modal = $('#modal-bill-form');
					modal.find('input[name="consolidated"]').val(consolidated);
					modal.modal('toggle')
				});
			}
		},
		order: [[3, 'DESC']],
		columns: [
		{data: 'number', name: 'number'},
		{data: 'fullname', name: 'user_id'},
		{data: 'created_at', name: 'created_at'},
		{data: 'shippingstate', name: 'shippingstate_id'},
		{data: 'num_trackings', orderable: false, searchable: false},
		{data: 'closed_at', name: 'closed_at'},
		{data: 'action', orderable: false, searchable: false}
		]
	});
	$('#addForm').click(function (e) {
		e.preventDefault();
		$(this).attr('disabled', '');
		$.ajax({
			url: path + 'consolidados',
			type: 'POST',
			dataType: 'json',
			data: {
				index: 'create'
			}
		})
		.done(function(response) {
			$('tr').removeClass('info');
			$('#btn-create-tracking').show();
			$('#btns-edit-tracking').hide();
			$('#tracking-form-register input[name=_method]').val('POST');
			$('#tracking-form-register').attr('action', path + 'tracking');
			$('.f-close').text(response.cierre);
			$('.f-create').text(response.creacion);
			$('input[name="user_id"]').val(response.user.name + ' ' + response.user.last_name + ((response.user.num_id) ? ' / ' + response.user.num_id : ''));
			$('form#tracking-form-register input#consolidated_id').val(response.id);
			$('#modal-send-form').modal('toggle').find('.modal-title').html('<span class="fa fa-plus"></span> Crear Nuevo Consolidado.');
			trackTable.draw();
			consTable.draw();
			$('#addForm').removeAttr('disabled');
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
			if (response.msg) {
				toastr.error(response.msg);
				return;
			}
			$('form#tracking-form-register')[0].reset();
			trackTable.draw();
			toastr.success('Tracking Registrado');
		})
		.fail(function(response) {
			response = response.responseJSON;
			toastr.error('Opps al parecer a ocurrido un error');
			for(let i in response) {
				let html = '<ul>';
				html += '<li>'+response[i][0]+'</li>';
				html += '</ul>';
				toastr.error(html);
			}
			console.clear();
		});
	});
	$('form#searchconsolidate').submit(function (e) {
		e.preventDefault();
		consTable.draw();
	});
	$('button#btn-cancel-tracking, button#btn-edit-tracking').click(function () {
		if ($(this)[0].id == 'btn-edit-tracking') {
			let form = $('#tracking-form-register');
			let url = form.attr('action');
			let data = form.serializeArray();
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
				toastr.success('Tracking Editado.');
			})
			.fail(function(response) {
				toastr.error('Opps al parecer a ocurrido un error');
			});
		}
		$('#tracking-form-register').attr('action', path + 'tracking');
		$('#tracking-form-register')[0].reset();
		$('#btn-create-tracking').show();
		$('#btns-edit-tracking').hide();
		$('#tracking-form-register input[name=_method]').val('POST')
		$('tr').removeClass('info');
		if ($(this)[0].id == 'btn-cancel-tracking') {
			toastr.info('Edición Cancelada.');
		}
	});
	$('button#consolidated-consolidated').click(function () {
		$('button#consolidated-consolidated').attr('disabled', 'disabled')
		let id = $('form#tracking-form-register input#consolidated_id')[0].value;
		$.post(path + 'formalize-consolidated/' + id, function (response) {
			consTable.draw();
			$('#modal-send-form').modal('toggle');
			toastr.success('Consolidado Formalizado.');
			setTimeout(function () {consTable2.draw();}, 1000);
			$('#tracking-form-register').attr('action', path + 'tracking');
			$('#tracking-form-register')[0].reset();
			$('#btn-create-tracking').show();
			$('#btns-edit-tracking').hide();
			$('#tracking-form-register input[name=_method]').val('POST');
			$('tr').removeClass('info');
			$('form#tracking-form-register input#consolidated_id').val('');
			$('button#consolidated-consolidated').removeAttr('disabled')
		})
		.fail(function(response) {
			toastr.warning(response.responseJSON.msg);
			console.clear();
			$('button#consolidated-consolidated').removeAttr('disabled')
		});
	});
	$('div#header-search-b').hide();
	$('#search-cons-b').click(function (e) {
		e.preventDefault();
		$('div#header-search-b').fadeToggle();
	});
	$('form#search-consolidate-formalized').submit(function (e) {
		e.preventDefault();
		consTable2.draw();
	});
	$('#consolidated-save, #modal-send-form button[class="close"]').click(function () {
		if ($('#tracking-table tbody tr td').length == 1) {
			toastr.info('Debe de agregar trackings para guardar el consolidado.');
			return;
		}
		$('#tracking-form-register')[0].reset();
		$('#tracking-form-register').attr('action', path + 'tracking');
		$('#tracking-form-register').find('[name="_method"]').val('POST');
		$('#modal-send-form').modal('toggle');
		consTable.draw();
	});
	function cargarEventos(id) {
		$.post(path + 'formalized/' + id, function (response) {
			$('div#modal-send_formalizated_edit').find('h4')
			.html('<span class="fa fa-list"></span> Eventos del Consolidado: ' + response.consolidated.number);
			let event = response.event;
			let template, item;
			$('ul#events-formalized').html('');
			for(let e in event) {
				template = $('#timeline-template').html();
				item = $(template).clone();	
				item.find(".bg-teal").text(event[e].created);
				item.find(".time").html('<i class="fa fa-clock-o"></i> ' + event[e].hour);
				if (event[e].consolidated_id) {
					item.find(".timeline-header a").text('Consolidado ' + response.consolidated.number);
				} else {
					item.find(".timeline-header a").text('Tracking ' + event[e].trackings.tracking);
				}
				item.find(".timeline-body").html(event[e].events.event);
				item.find(".timeline-footer a").attr('evento', event[e].id);
				$('ul#events-formalized').append(item);
			}
			$('a#delete-event').click(function (e) {
				e.preventDefault();
				let event = $(this).attr('evento');
				$.post(path + 'event/' + event, {'_method': 'DELETE'}, function () {
					cargarEventos(id)
					toastr.success('Evento Eliminado.');
				});
			});
		});
	}
	$('#price_form').submit(function (e) {
		e.preventDefault();
		$(this).find('button[type="submit"]').attr('disabled','disabled');
		let data = $(this).serializeArray();
		$.post(path + 'bill', data, function (response) {
			consTable2.draw();
			$('#price_form')[0].reset();
			$('#price_form').find('button[type="submit"]').removeAttr('disabled');
			$('#modal-bill-form').modal('toggle')
		})
		.fail(function (response) {
			response = response.responseJSON;
			$('#price_form').find('button[type="submit"]').removeAttr('disabled');
			console.clear();
			for(let i in response) {
				toastr.error(response[i][0]);
				return;
			}
		});
	});
	$('button#show-closed').click(function () {
		consTable.draw();
		consTable2.draw();
	});
	$.post(path + 'users-all', function (response) {
		let u = response.users;
		let html = '';
		for(let i in u) {
			html += '<option value="' + u[i].name + ' ' + u[i].last_name + ((u[i].num_id) ? ' / ' + u[i].num_id : '') + '" id="' + u[i].id + '"></option>';
		}
		$('#user_id').html(html)
	});
	$('#user-of-consolidated').submit(function (e) {
		e.preventDefault();
		let consolidated = $('form#tracking-form-register #consolidated_id').val();
		let url  = path + 'user-consolidated/' + consolidated;
		let data = $(this).serializeArray();
		let user = $('datalist#user_id option[value="'+$('input[list="user_id"]').val()+'"]').attr('id');
		data[2].value = user;
		if (! user) {
			toastr.info('Debe seleccionar un usuario');
			return;
		}
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: data,
		})
		.done(function(response) {
			if (response.msg) {
				toastr.info(response.msg);
				return;
			}
			toastr.success('Usuario agregado al consolidado!');
		})
		.fail(function(response) {
			toastr.error('Error al editar.');
		});
	});
	$('input[name="user_id"]').focus(function () {
		localStorage.setItem('user', $(this).val());
		$(this).val('');
	});
	$('input[name="user_id"]').blur(function () {
		if ($(this).val() == '') {
			$(this).val(localStorage.getItem('user'));
		} else {
			$(this).val($(this).val())
		}
		localStorage.removeItem('user');
	});
	var trackTable2 = $('table#table-edit-formalized').DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		searching: false,
		render: true,
		language: translateTableCustom,
		ajax: {
			url: path + 'events',
			data: function (d) {
				d.consolidated_id = function () {
					let num = $('table#table-edit-formalized').attr('consolidated');
					if (num > 0) {
						return num;
					} else {
						return null;
					}
				}
			},
			complete: function () {
				let tr = $('table#table-edit-formalized tr');
				for (var i = 0; i <= tr.length; i++) {
					let t = tr[i];
					let td = $(t).children('td');
					let text = $(td[2]).text();
					$(td[2]).html(text);
				}
			}
		},
		order: [[2, 'DESC']],
		columns: [
		{data: 'fecha', name: 'created_at', orderable: false, searchable: false},
		{data: 'hora', name: 'created_at', orderable: false, searchable: false},
		{data: 'evento', name: 'event_id', orderable: false, searchable: false},
		]
	});
}
if (location.href.indexOf('/tracking') > 0) {
	localStorage.removeItem('trackings');
	$('div#header-search-a').hide();
	$('#search-cons-a').click(function (e) {
		e.preventDefault();
		$('div#header-search-a').fadeToggle();
	});
	$.post(path + 'consolidados/data-events', function (response) {
		let events = response.events;
		let html = '<option value="">Seleccione un evento</option>';
		for(let i in events) {
			html += '<option value="' + i + '">';
			html += events[i];
			html += '</option>';
		}
		$('select#event').html(html);
		$('select#event_to').html(html);
	});
	$('form#searchconsolidate').submit(function (e) {
		e.preventDefault();
		localStorage.removeItem('trackings');
		trackings.draw();
	});
	$('#add-events').click(function () {
		$('#massive_event').modal('toggle');
	});
	$('#save_events').click(function (e) {
		e.preventDefault();
		let trac = localStorage.getItem('trackings');
		let eve = $('select#event_to').val();
		if (trac) {
			trac = trac.split(',');
			if (eve == '') {
				toastr.warning('Debe agregar un evento');
				return;
			}
		} else {
			toastr.warning('Debe seleccionar trackings');
			return;
		}
		$.post(path + 'massive_events/' + eve, {trackings:trac}, function (response) {
			localStorage.removeItem('trackings');
			trackings.draw();
			$('#massive_event').modal('toggle');
			$('select#event_to').val('');
			if (response.errors.length > 0) {
				let html = '';
				for(let i in response.errors) {
					html += '<li>'+response.errors[i]+'</li>'
				}
				$('button#consolidated-consolidated').removeAttr('disabled')
				toastr.info('Estos trackings ya pasaron por ese evento. <br>' + html);
			}
		})
		.fail(function (response) {
			response = response.responseJSON;
			for(let i in response) {
				toastr.error(response[i][0]);
				return;
			}
			console.clear();
		});
	});
	var trackings = $('table#trackings-a-table').DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		render: true,
		language: translateTable,
		ajax: {
			url: path + 'trackings',
			data: function (d) {
				d.created_at = $('input#create_date').val();
				d.event_id = $('select#event').val();
			},
			complete: function () {
				let sto = localStorage.getItem('trackings');
				if (sto) {
					let inputs = $('input#checkboxTracking')
					for (var i = 0; i <= inputs.length - 1; i++) {
						tracking = $(inputs[i]).attr('tracking')
						if (sto.includes(tracking)) {
							$(inputs[i]).attr('checked', 'checked')
						}
					}
				}
				$('.control__indicator').click(function () {
					let tracking = $(this).parent().find('input[type="checkbox"]').attr('tracking');
					let trackings = localStorage.getItem('trackings');
					let all = [];
					if (trackings) {
						all = trackings.split(',');
						if (all.includes(tracking)) {
							all.splice(all.indexOf(tracking), 1);
							localStorage.setItem('trackings', all)
						} else {
							all.push(tracking);
							localStorage.setItem('trackings', all);
						}
					} else {
						all.push(tracking);
						localStorage.setItem('trackings', all);
					}
				});
			}
		},
		columns: [
		{data: 'tracking_num', name: 'trackings.tracking'},
		{data: 'description', name: 'id', orderable: false, searchable: false},
		{data: 'consolidated_num', name: 'consolidateds.number'},
		{data: 'user', name: 'users.id'},
		{data: 'created_at', name: 'trackings.created_at'},
		{data: 'event', name: 'trackings.shippingstate_id'},
		{data: 'action', name: 'action', orderable: false, searchable: false},
		]
	});
}
