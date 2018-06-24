@extends('emails.layouts')
@section('saludo')
	<strong style="color: #0042aa;">
		Bienvenido
	</strong>
@endsection
@section('title')
	<p style="text-align: center;">
		<strong><b style="color: #b51a00">U.S Cargo</b> el Servicio Courier de Importadora Sky.</strong>
	</p>
@endsection
@section('content')
	<tr>
		<td style="padding: 5px 0 5px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
			<p>
				A continuación encontraras tu dirección en Estados Unidos, la cual debes registrar como dirección de envío o shipping address para el envío de todas tus compras al igual utilizar como segundo apellido Sky.
				{{-- Usted ha creado un casillero el día de Hoy, esto le permitirá tener una dirección en Miami, FL. donde van a llegar los artículos o mercancía que compre en los Estados Unidos o que sus proveedores le envíen; permítanos asesorarle en cualquier proceso logístico y de compras en el exterior, nosotros podemos guiarlo en como usted debe hacer sus compras en línea, recuerde que nosotros le haremos llegar sus envíos hasta la puerta de su casa o negocio en Colombia, y recuerde que tanto el CASILLERO como la ZONA DE ALMACENAJE para consolidar sus compras son completamente gratis, siempre buscamos que nuestros clientes ahorren en sus envíos. --}}
			</p>
			<p>
				{{-- Le invitamos a completar su perfil de usuario para poder administrar sus envios <a href="{{ route('profile') }}">Aqui!</a>. --}}
				Nuevo Usuario Registrado.
			</p>
			{{-- <p> --}}
				{{-- Cuando su proveedor o la página web donde realiza la compra le pide la direccián de envio o SHIPPING ADDRESS usted deberá escribirla de la siguiente manera: --}}
			{{-- </p> --}}
		</td>
	</tr>
	<tr>
		<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
			<li><b>Nombre:</b> {{ $data['name'] }}</li>
			<li><b>Apellido:</b> {{ $data['last_name'] }} <b>Sky</b></li>
			<li><b>Dirección / Address:</b> 8566 NW 61th ST</li>
			<li><b>Oficina / Office:</b> CO132</li>
			<li><b>Ciudad / City:</b> Miami</li>
			<li><b>Estado / State:</b> Florida</li>
			<li><b>Codigo Postal / ZIP CODE:</b> 33166</li>
			<li><b>Telefono / Phone:</b> (512) 234 7692</li>
			<li><b>N° de Identificacion:</b> {{ $data['num_id'] }}</li>
		</td>
	</tr>
	<tr>
		<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
			<b>El link para entrar desde su cuenta es:</b>
			<p>
				<li><b><a href="{{ url('/') }}">{{ url('/') }}</a></b></li>
			</p>
			<p>
				Tener en cuenta que si requiere que le consolidemos sus paquetes para realizar un solo envío, debe notificarnos en la plataforma web de su casillero los números de guía / Tracking number que debemos juntar.
			</p>
			<p>
				Cuando estén llegando estos paquetes, nuestro sistema le notificara la fecha de entrega, tipo de paquete y contenido, cuando toda su carga este consolidada procederemos con el envio hacia el destino final que usted indique en Colombia.
			</p>
		</td>
	</tr>
@endsection