@extends('emails.layouts')

@section('title')
	<strong>
		Hola, el siguiente correo es para notificarle que el siguiente consolidado le fue registrado un nuevo evento.
	</strong>
@endsection

@section('content')
	<ul>
		<li>Consolidado n°: {{ $consolidado->number }}</li>
		<li>Cliente: {{ $consolidado->user->fullName() }}</li>
		<li>Total de trackigns: {{ $consolidado->trackings->count() }}</li>
		<li><b>Evento: {{ $consolidado->eventsUsers->last()->events->event }}</b></li>
	</ul>
	<p>Trackings:</p>
	<ul>
		@foreach($consolidado->trackings as $tracking)
		<li>Tracking: {{ $tracking->tracking }} - Descripción: {{ $tracking->description }}</li>
		@endforeach
	</ul>
@endsection