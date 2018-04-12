@extends('adminlte::layouts.auth')

@section('htmlheader_title')
Recuperar usuario.
@endsection

@section('content')
<body class="hold-transition login-page">
    <div id="app" v-cloak>
        <div class="login-box">
            <div class="login-logo">
                <img class="center-block" src="/img/skyimport.png" height="100px">
            </div><!-- /.login-logo -->

            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="login-box-body">
                <p class="login-box-msg">Hola, {{ $user->name }} {{ $user->last_name }},<br> Por cambios en nuestra plataforma, debes confirmar su número de identificación para acceder a su recuperar tu cuenta, validando el código que se envio a tu correo, y registrar tu nueva contraseña.</p>
                <form id="form-recovery" action="{{ url('/recuperar-usuario', $user->id) }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Código enviado al correo." name="_codigo" value="{{ old('_codigo') }}" />
                        <span class="fa fa-barcode form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Cédula de Identidad." name="number_id" value="{{ old('number_id') }}" />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}." name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Confirmación de contraseña." name="password_confirmation"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                        </div><!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.buttonsign') }}</button>
                        </div><!-- /.col <--></-->
                    </div>
                </form>

                {{-- @include('adminlte::auth.partials.social_login') --}}
                <a href="{{ url('/password/reset') }}">{{ trans('adminlte_lang::message.forgotpassword') }}</a><br>
                @if(env('REGISTRATION_OPEN'))
                <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a>
                @endif

            </div><!-- /.login-box-body -->

        </div><!-- /.login-box -->
    </div>
    @include('adminlte::layouts.partials.scripts_auth')

</body>

@endsection