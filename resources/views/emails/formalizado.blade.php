@extends('emails.layouts')
@section('title')
	<strong>
		Hola, el siguiente correo es para notificarle que el siguiente consolidado fue formalizado.
	</strong>
@endsection
@section('content')
	<ul>
		<li> Consolidado n°: {{ $consolidado->number }} </li>
		<li> Cliente: {{ $consolidado->user->fullName() }}.</li>
		<li> Total de trackigns: {{ $consolidado->trackings->count() }}.</li>
		<li> Identificación: {{ $consolidado->user->num_id }}.</li>
	</ul>
	<p>Recibido:</p>
	<ul>
		@foreach($consolidado->trackings as $tracking)
		<li> Tracking: {{ $tracking->tracking }} - Descripción: {{ $tracking->description }}.</li>
		@endforeach
	</ul>
@endsection