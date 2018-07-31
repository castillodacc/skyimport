@extends('emails.layouts')

@section('title')
    <strong>Hola, este correo es para notificarte que el siguiente consolidado fue formalizado.</strong>

@endsection


@section('content')
	<ul>
	    <li><b>Evento: Consolidado {{ $consolidado->number }}</b></li>
		<li>Cliente: {{ $consolidado->user->fullName() }}</li>
		<li>Total de Trackings: {{ $consolidado->trackings->count() }}</li> 
	</ul>

	<ul>
	    <li>Trackings:</li>
		@foreach($consolidado->trackings as $tracking)
		<li>Tracking: {{ $tracking->tracking }} - Descripción: {{ $tracking->description }}</li>
		@endforeach
	</ul>
@endsection