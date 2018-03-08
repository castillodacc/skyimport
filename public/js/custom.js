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

let url = location.origin;
if (location.pathname == '/perfil') {
	// al cargar la pagina se colocan los inputs con readonly
	let inputs = $('form#profile').find('input, textarea, select');
	inputs.attr('disabled', '');
	// se altera el estado de los inputs con este boton
	$('button#active_edit_profile').click(function (e) {
		e.preventDefault();
		if ($(inputs[0]).attr('disabled') == undefined) {
			inputs.attr('disabled', '');
		} else {
			inputs.removeAttr('disabled');
		}
	});
	let id = $('form#profile')[0].action.split('/')[4];
	$.get(url+'/usuarios/'+id, 	function (response) {
		let option = '<option value="" selected disabled>Seleccione un pais</option>';
		for (let i = 0; i < response.countries.length; i++) {
			let id = response.countries[i].id;
			let country = response.countries[i].country;
			option += '<option value="'+id+'">'+country+'</option>';
		}
		$('select#country').html(option);
		for (let i = 0; i < inputs.length; i++) {
			if (inputs[i].id) {
				let value = response.user[inputs[i].name];
				$(inputs[i]).val(value)
			}
		}
	});
	// eventos al enviar el formulario del perfil
	$('form#profile').submit(function (e) {
		e.preventDefault();
		if ($(inputs[0]).attr('disabled') !== undefined) {
			toastr.warning("Debe activar la edición en el boton Editar Perfil!")
			return;
		}
		let url  = $(this).attr('method');
		console.log(url)
		return
		var data = $(this).serializeArray();
		$.ajax({
			url: location.origin + '/usuarios/',
			type: 'POST',
			dataType: 'json',
			data: data,
		})
		.done(function(resul) {
			console.log('usuario editado exitosamente');
		})
		.fail(function() {
			console.log('error');
		});
	});

}
