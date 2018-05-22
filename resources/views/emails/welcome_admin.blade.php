@extends('emails.layouts')

@section('title')
	<strong>
		Bienvenido a U.S Cargo el Servicio Courier de Importadora Sky.
	</strong>
@endsection

@section('content')
	<tr>
		<td style="padding: 5px 0 5px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
			<p>Nuevo Usuario Registrado.</p>
		</td>
	</tr>
	<tr>
		<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
			<li><b>Nombre:</b> {{ $data['name'] }}</li>
			<li><b>Apellido:</b> {{ $data['last_name'] }} <b>Sky</b></li>
			<li><b>Correo:</b> {{ $data['email'] }} </li>
			<li><b>N° de Identificación:</b> {{ $data['num_id'] }}</li>
		</td>
	</tr>
	<tr>
		<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
			<b>El link para entrar a su cuenta es:</b>
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