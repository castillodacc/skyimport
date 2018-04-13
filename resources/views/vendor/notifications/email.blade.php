@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Hola!
@endif
@endif

{{-- Intro Lines --}}
<p>Usted está recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.</p>

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
Restaurar Contraseña
@endcomponent
@endisset

<p>Si no solicitó restablecer la contraseña, no se requieren más acciones.</p>

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Saludos,<br>{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
Si tiene problemas para hacer clic en "Restaurar Contraseña" botón, copiar y pegar la URL a continuación en su navegador web : [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
