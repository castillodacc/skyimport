@extends('emails.layouts')

@section('title')
    <strong>
        Su consolidado ha sido recibido en Colombia, adjuntamos la orden de servicio de su consolidado.
    </strong>
@endsection

@section('content')
	<ul>
		<li> <b>Evento: Coordinar entrega y cancelación de Orden de servicio con el destinatario.</b></li>
		<li> Cliente: {{ $consolidated->user->fullName() }}.</li> 
		<li> Consolidado n°: {{ $consolidated->number }} </li>
		<li> Total de trackigns: {{ $consolidated->trackings->count() }}</li>
		<li>
            Trackings:
        	<ul>
        		@foreach($consolidated->trackings as $tracking)
        		<li> {{ $tracking->tracking }} - Descripción: {{ $tracking->description }}.</li>
        		@endforeach
        	</ul>
        </li>
        <br>  
		<li> Total peso del envío: {{ $consolidated->weight }} Lb.</li>
		<li> <b style="font-size: 20px">Total a pagar: {{ number_format($consolidated->bill, 2, ',', '.') }} COP.</b></li>
		<li> Fecha de expedicion de orden de servicio: {{ \Carbon::now()->format('Y/m/d') }}.</li>
	</ul>

@endsection