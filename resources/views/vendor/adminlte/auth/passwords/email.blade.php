@extends('adminlte::layouts.auth')
@section('htmlheader_title')
    Password recovery
@endsection
@section('content')
<body class="login-page">
    <div id="app">
        <div class="login-box">
        <div class="login-logo">
            <img class="center-block" src="/img/sky.png">
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

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
            <p class="login-box-msg">Restablecer Contraseña</p>
            <form method="post">
                <div class="alert alert-success" style="display: none;"></div> 
                <div class="form-group has-feedback">
                    <input type="email" placeholder="Correo Electrónico" name="email" autofocus="autofocus" class="form-control"> 
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                 <div class="row">
                    <div class="col-xs-2"></div> 
                    <div class="col-xs-6 col-xs-offset-1"><button type="submit" class="btn btn-block btn-flat btn-primary"><span class="fa fa-send"></span> Enviar enlace</button></div> 
                    <div class="col-xs-2"></div>
                </div>
            </form>
            <a href="{{ url('/login') }}">Iniciar Sesion</a><br>
            <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a>
        </div>
    </div>
    </div>

    @include('adminlte::layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
