@extends('emails.layouts')


@section('content')
	<ul>
		@if($consolidado->shippingstate_id == 4)
		<li><b>Evento: Trackings del consolidado recibidos, Salida de la bodega de U.S.A, en transito Bogotá, Colombia.</b></li>
		@elseif($consolidado->shippingstate_id == 5)
		<li><b>Evento: Ingreso a inspección DIAN, 12/48 horas.</b></li>
		@elseif($consolidado->shippingstate_id == 9)
		<li><b>Evento: {!! $consolidado->eventsUsers->last()->events->event !!} - Balance $0</b></li>
		@else
		<li><b>Evento: {!! $consolidado->eventsUsers->last()->events->event !!}</b></li>
		@endif
		<li>Cliente: {{ $consolidado->user->fullName() }}</li>
		<li>Consolidado n°: {{ $consolidado->number }}</li>
		<li>Total de trackigns: {{ $consolidado->trackings->count() }}</li>
	</ul>
	
	<ul>
	    <li>Trackings:</li>
		@foreach($consolidado->trackings as $tracking)
		<li>Tracking: {{ $tracking->tracking }} - Descripción: {{ $tracking->description }}</li>
		@endforeach
	</ul>
@endsection