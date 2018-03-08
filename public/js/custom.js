"use strict";
toastr.options = {
	"closeButton": true,
	"debug": true,
	"newestOnTop": true,
	"progressBar": true,
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

let url = location.origin;
if (location.pathname == '/perfil') {
	// al cargar la pagina se colocan los inputs con readonly
	let inputs = $('form#profile').find('input, textarea, select');
	inputs.attr('disabled', '');
	$('#buttons_edit_perfil').hide();
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
		'avatar': 'Imagen Personal.'
	};
	// se altera el estado de los inputs con este boton
	$('button#active_edit_profile, button#cancel').click(function (e) {
		e.preventDefault();
		for (var i in messages) {
			$('small#'+i)
			.removeClass('text-danger')
			.addClass('text-muted')
			.text(messages[i])
		}
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
		let file = $(this).find('input[name="avatar"]')[0].files;
		console.log(file)
		let url  = $(this).attr('action');
		let data = $(this).serializeArray();
		data.push({ name: "avatar", value: file });
		// console.log(data.value)
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
			for (var i in messages) {
				$('small#'+i)
				.removeClass('text-danger')
				.addClass('text-muted')
				.text(messages[i])
			}
			UserProfile();
		})
		.fail(function(response) {
			for (var i in response.responseJSON) {
				$('small#'+i).addClass('text-danger').text(response.responseJSON[i])
			}
			toastr.error('Ups, Al parecer ah ocurrido un error!');
			// console.clear();
		});
	});
}
$('input[name="avatar"]').change(function (e) {
	if (this.files && this.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('div#avatar_profile').css({'background-image': 'url('+e.target.result+')'})
		}
		reader.readAsDataURL(this.files[0]);
	}
});
