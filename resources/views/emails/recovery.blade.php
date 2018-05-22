@extends('emails.layouts')
@section('title')
	<strong>
		Hola, el siguiente correo es para formalizar la recuperación de su contraseña.
	</strong>
@endsection
@section('content')
	<p>
		Su clave de recuperación de cuenta es: <b style="font-size: 25px">"{{ $numero }}"</b>.
	</p>
@endsection