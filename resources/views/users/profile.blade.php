@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="box box-primary">
        <div class="box-header with-border text-center">
            <h3 class="box-title">Perfil de usuario</h3>
            <button type="submit" class="btn btn-primary btn-xs pull-right"><span class="fa fa-edit"></span> Editar perfil</button>
        </div>
    <div class="box-body">
     <form id="" method="POST">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-user-circle text-primary"></span>
                                </div>
                                <input type="text" id="name" pattern="" name="name" class="form-control" placeholder="Nombres" required>
                            </div>
                            <small id="name" class="form-text text-muted">Nombres del usuario.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-user-circle-o text-primary"></span>
                                </div>
                                <input type="text" id="last_name" pattern="[A-Za-z]{1,70}" name="last_name" class="form-control" placeholder="Apellidos" required>
                            </div>
                            <small id="last_name" class="form-text text-muted">Apellidos del usuario.</small>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <div class="btn-group">
                           <button type="submit" class="btn btn-danger btn-sm"><span class="fa fa-close"></span> Cancelar</button>
                      </div>
                      <div class="btn-group">
                           <button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-send"></span> Guardar</button>
                      </div>
                    </div>
                </div>
        </form>
</div>
@endsection