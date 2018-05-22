@extends('emails.layouts')

@section('title')
	<strong>
		Orden de Servicio de su Consolidado:
	</strong>
@endsection

@section('content')
	<ul>
		<li> Cliente: {{ $consolidated->user->fullName() }}.</li>
		<li> Identificación: {{ $consolidated->user->num_id }}.</li>
		<li> Consolidado n°: {{ $consolidated->number }} </li>
		<li> Peso: {{ $consolidated->weight }} Lb.</li>
		<li> Total a pagar: {{ number_format($consolidated->bill, 2, ',', '.') }} COP.</li>
		<li> Fecha de expedicion de factura: {{ \Carbon::now()->format('Y/m/d') }}.</li>
	</ul>
	<strong>Recibido:</strong>
	<ul>
		@foreach($consolidated->trackings as $tracking)
		<li> Tracking: {{ $tracking->tracking }} - Descripción: {{ $tracking->description }}.</li>
		@endforeach
	</ul>
@endsection