@extends('emails.layouts')



@section('content')
	<ul>
		<li>
		    <b>
			Evento: 
			@if($data->eventsUsers->last()->events->id == 12)
			Hemos recibido tu paquete en nuestra bodega de U.S.A.
			@else
			{{ $data->eventsUsers->last()->events->event }}
			@endif
			</b>
	    </li>
		<li>Cliente: {{ $data->consolidated->user->fullName() }}</li>
		<li><b>Tracking: {{ $data->tracking }}</b></li>
		<li>Consolidado: {{ $data->consolidated->number }}</li>
		<li>Recibido: {{ \Carbon::now()->format('Y/m/d') }}.</li>
	</ul>
@endsection

