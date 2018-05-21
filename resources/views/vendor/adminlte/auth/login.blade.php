@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Inicio de sesión.
@endsection

@section('content')
    <body class="hold-transition login-page">
    <div id="app" v-cloak>
        <div class="login-box">
            <div class="login-logo">
                <img class="center-block" src="/img/sky.png">
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
                <p class="login-box-msg"> {{ trans('adminlte_lang::message.siginsession') }} </p>
                <form action="{{ url('/login') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="{{ trans('adminlte_lang::message.email') }}" name="email" value="{{ old('email') }}" />
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input style="display:none;" type="checkbox" name="remember"> {{ trans('adminlte_lang::message.remember') }}
                                </label>
                            </div>
                        </div><!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-block btn-flat btn-primary"><span class="fa fa-sign-in"></span> {{ trans('adminlte_lang::message.buttonsign') }}</button>
                        </div><!-- /.col <--></-->
                    </div>
                </form>
                {{-- @include('adminlte::auth.partials.social_login') --}}
                <div class="row">
                    <div class="col-xs-12 btn-group">
                        <a class="btn btn-flat btn-xs btn-default" href="{{ url('consultar-consolidado') }}"><span class="fa fa-hand-pointer-o"></span> Consultar consolidado</a>
                        <a class="btn btn-flat btn-xs btn-default pull-right" href="{{ url('/password/reset') }}"><span class="fa fa-question-circle"></span> {{ trans('adminlte_lang::message.forgotpassword') }}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 btn-group">
                        @if(env('REGISTRATION_OPEN'))
                        <a class="btn btn-flat btn-xs pull-right btn-default" href="{{ url('/register') }}" class="text-center"><span class="fa fa-user-plus"></span> {{ trans('adminlte_lang::message.registermember') }}</a>
                        @endif
                    </div>
                </div>
            </div><!-- /.login-box-body -->

        </div><!-- /.login-box -->
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