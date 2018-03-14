@extends('vendor.adminlte.layouts.app')

@section('main-content')
<div class="box box-primary">
    <div class="box-header">
        <a id="addform" href="" class="btn btn-primary btn-xs" data-toggle="modal" data-placement="top" data-target="#send_form" title="Crear consolidado"><span class="fa fa-plus"></span> Registrar</a>
        <a class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Buscar por campo" id="search-avanced"><span class="fa fa-search"></span> Busqueda avanzada</a>
        <div class="pull-right">
            <div class="btn-group">
                <a id="viewConsolidates" class="btn btn-info btn-xs" href="#" data-title="Show" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Mostrar consolidado"><span class="fa fa-eye"></span></a>
            </div>
            <div class="btn-group">
                <a id="deleteConsolidates" class="btn btn-danger btn-xs" href="#" data-title="Close" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Cancelar"><span class="fa fa-trash"></span></a>
            </div>
        </div>
    </div>
    <div class="box-header" id="header2" style="display: none;">
        <form id="searchconsolidate" method="POST" role="form">
            <div class="row"> 
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-location-arrow text-primary"></span>
                        </div>
                        <input type="text" class="form-control input-sm" id="traking" name="number_record" pattern="" title="" placeholder="# Traking">
                    </div>
                    <small id="number_record" class="form-text text-muted">Traking.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-user text-primary"></span>
                        </div>
                        <input type="text" id="user" name="patient_id" pattern="" name="user"  class="form-control input-sm" placeholder="Nombre del usuario">
                    </div>
                    <small id="user" class="form-text text-muted">Usuario.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar text-primary"></span>
                        </div>
                        <input type="text" id="create_date" pattern="" name="create_date" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de creacion.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-check text-primary"></span>
                        </div>
                        <select id="status" name="status" class="form-control input-sm"></select>
                    </div>
                    <small id="status" class="form-text text-muted">Estado.</small>
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Buscar filtros"><span class="fa fa-search"></span> Buscar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="box-body">
        <table id="users-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center">Elegir</th>
                    <th>Traking</th>
                    <th>Usuario</th>
                    <th>Fecha de creacion</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr class="success">
                    <td class="text-center"><input type="radio" name="consolidated" id="1"></td>
                    <td>123456789123</td>
                    <td>Emanuel Surveyor Parra Coello</td>
                    <td>09/03/2018</td>
                    <td>Despachado</td>
                </tr>
                <tr class="warning">
                    <td class="text-center"><input type="radio" name="consolidated" id="2"></td>
                    <td>123456789123</td>
                    <td>Emanuel Surveyor Parra Coello</td>
                    <td>09/03/2018</td>
                    <td>En proceso</td>
                </tr>
                <tr class="danger">
                    <td class="text-center"><input type="radio" name="consolidated" id="3"></td>
                    <td>5151515565656</td>
                    <td>Emanuel Surveyor Parra Coello</td>
                    <td>08/03/2018</td>
                    <td>Cerrado</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@include('modals.send_form')
@endsection