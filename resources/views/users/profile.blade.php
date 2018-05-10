@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="row">  
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-body box-profile">
        <div id="avatar_profile" class="profile-user-img img-circle" style="height: 100px">
          <img class="img-circle img-responsive" style="height: 100%; width: 100%" src="{{ Auth::user()->pathAvatar($id) }}">
        </div>
        <h3 class="profile-username text-center">{{ $user->fullName() }}.</h3>
        <p class="text-muted text-center">{{ $user->role->rol }}.</p>
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Consolidados sin formalizar:</b>
            <a id="sin-form" class="pull-right"></a>
          </li>
          <li class="list-group-item">
            <b>Consolidados formalizados:</b>
            <a id="form" class="pull-right"></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active">
          <a href="#profile" data-toggle="tab" aria-expanded="true">Perfil</a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="profile">
          <div class="box-header with-border">
            <button class="btn btn-xs pull-right btn-flat btn-primary" id="active_edit_profile"><span class="fa fa-pencil"></span> Editar perfil</button>
          </div>
          <form id="profile" enctype="multipart/form-data" action="{{ route('usuarios.update', $user->id) }}">
            {{ csrf_field() }} {{ method_field('PUT') }}
            <div class="box-body">
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="fa fa-user-circle"></span>
                    </div>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nombres">
                  </div>
                  <small id="name" class="form-text text-muted">Nombres del usuario.</small>
                </div>
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="fa fa-user-circle-o"></span>
                    </div>
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Apellidos">
                  </div>
                  <small id="last_name" class="form-text text-muted">Apellidos del usuario.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="fa fa-phone"></span>
                    </div>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Telefono">
                  </div>
                  <small id="phone" class="form-text text-muted">Telefono de contacto.</small>
                </div>
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="glyphicon glyphicon-envelope"></span>
                    </div>
                    <input type="email" id="email" name="email" class="form-control" placeholder="ejemplo@ejemplo.com">
                  </div>
                  <small id="email" class="form-text text-muted">Correo electronico.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="fa fa-id-card"></span>
                    </div>
                    <input type="text" id="num_id" name="num_id" class="form-control" placeholder="ID">
                  </div>
                  <small id="num_id" class="form-text text-muted">Documento de identidad.</small>
                </div>
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="fa fa-globe"></span>
                    </div>
                    <select id="country_id" name="country_id" class="form-control"></select>
                  </div>
                  <small id="country_id" class="form-text text-muted">Pais de origen.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="fa fa-map"></span>
                    </div>
                    <input type="text" id="city" name="city" class="form-control" placeholder="Ciudad">
                  </div>
                  <small id="city" class="form-text text-muted">Ciudad de origen.</small>
                </div>
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="fa fa-map-o"></span>
                    </div>
                    <select id="state_id" name="state_id" class="form-control">
                      <option value="">Seleccione primero un pais.</option>
                    </select>
                  </div>
                  <small id="state_id" class="form-text text-muted">Departamento o Estado.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6"> 
                  <textarea id="address" name="address" class="form-control" placeholder="Direccion principal"></textarea>
                  <small  class="form-text text-muted" id="address">Direccion principal del usuario.</small>
                </div>
                <div class="form-group col-md-6"> 
                  <textarea id="address_two" name="address_two" class="form-control" placeholder="Direccion secundaria"></textarea>
                  <small id="address_two" class="form-text text-muted">Direccion secundaria del usuario.</small>
                </div> 
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <input type="file" name="avatar" accept="image/*">
                  </div>
                  <small id="avatar" class="form-text text-muted">Imagen Personal.</small>
                </div>
              </div>
            </div>
            <div id="buttons_edit_perfil" class="box-footer">
              <div class="pull-right">
                <div class="btn-group">
                  <button id="cancel" type="button" class="btn btn-danger btn-sm btn-flat"><span class="fa fa-close"></span> Cancelar</button>
                </div>
                <div class="btn-group">
                  <button type="submit" class="btn btn-primary btn-sm btn-flat"><span class="fa fa-send"></span> Enviar</button>
                </div>
              </div>
            </div>
          </form>
        </div> 
      </div>
    </div> 
  </div>
</div>
@endsection