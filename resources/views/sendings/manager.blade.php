@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="box box-primary">  
    <div class="box-header with-border">
        <h3 class="box-title">Consolidados abiertos:</h3>
        <div class="pull-right">
            <div class="btn-group">
                <button id="search-cons-a" type="button" class="btn bg-green btn-xs btn-flat" data-title="Search" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Buscar filtros"><span class="fa fa-search"></span></button>
            </div>
            <div class="btn-group">
                <button id="extendConsolidated" type="button" class="btn btn-warning btn-xs btn-flat" data-title="Extend" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Extender consolidado"><span class="fa fa-calendar-plus-o"></span></button>
            </div>
            <div class="btn-group">
                <button id="viewConsolidated" type="button" class="btn btn-default btn-xs btn-flat" data-title="Show" data-toggle="modal" data-target="#modal-send-show" data-placement="top" rel="tooltip" title="Mostrar consolidado"><span class="fa fa-eye"></span></button>
            </div>
            <div class="btn-group">
                <a class="btn bg-teal btn-xs btn-flat" href="" data-title="Update" data-toggle="modal" data-target="#modal-send-edit" data-placement="top" rel="tooltip" title="Actualizar"><span class="fa fa-edit"></span></a>
            </div>
            @if(Auth::user()->rol_id == 2)
            <div class="btn-group">
                <button id="editConsolidated" type="button" class="btn btn-primary btn-xs btn-flat" data-title="Update" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Actualizar"><span class="fa fa-edit"></span></button>
            </div>
            @endif
            <div class="btn-group">
                <button id="deleteConsolidated" type="button" class="btn btn-danger btn-xs btn-flat" data-title="Delete" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Cancelar"><span class="fa fa-trash"></span></button>
            </div>
        </div>
    </div>
    <div id="header-search-a" class="box-header">
        <form id="searchconsolidate" method="POST" role="form">
            <div class="row"> 
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-location-arrow"></span>
                        </div>
                        <input type="text" class="form-control input-sm" id="consolidated" name="consolidated" placeholder="Consolidado">
                    </div>
                    <small id="number_record" class="form-text text-muted">Consolidado.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-plus-o"></span>
                        </div>
                        <input type="text" id="create_date" name="create_date" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de creacion.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-times-o"></span>
                        </div>
                        <input type="text" id="close_date" name="close_date" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="close_date" class="form-text text-muted">Fecha de cierre.</small>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn bg-green btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Buscar filtros"><span class="fa fa-search"></span> Buscar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="box-body table-responsive">
        <div class="col-md-12">
             <table id="consolidated-a-table" class="table table-sm table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><span class="fa fa-check-circle-o"></span> Elegir</th>
                    <th><span class="fa fa-cube"></span> Consolidado</th>
                    <th><span class="fa fa-user"></span> Usuario</th>
                    <th><span class="fa fa-calendar-plus-o"></span> Creación</th>
                    <th width="15%"><span class="fa fa-check-square-o"></span> Estado</th>
                    <th><span class="fa fa-location-arrow"></span> Trackings</th>
                    <th><span class="fa fa-calendar-times-o"></span> Cierre</th>
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>is13758797380</td>
                    <td>Emanuel Parra</td>
                    <td>09/03/2018</td>
                    <td><span class="label label-info">Pendiente formalizacion</span></td>
                    <td>09/03/2018</td>
                </tr>
            </tbody>
        </table>
        </div>
       
    </div>
    @if(Auth::user()->rol_id == 2 || 1)
    <div class="box-footer">
        <a id="addForm" href="#" class="btn btn-primary btn-sm btn-flat" data-placement="top" title="Crear consolidado"><span class="fa fa-plus"></span> Nuevo consolidado</a>
    </div>
    @endif
</div>

<div class="box box-primary">
     <div class="box-header with-border">
        <h3 class="box-title">Consolidados formalizados</h3>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn bg-green btn-xs btn-flat" href="" data-title="Search" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Buscar filtros"><span class="fa fa-search"></span></a>
            </div>
            <div class="btn-group">
                <a class="btn btn-info btn-xs btn-flat" href="" data-title="Show" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Mostrar consolidado"><span class="fa fa-eye"></span></a>
            </div>
            <div class="btn-group">
                <a class="btn btn-primary btn-xs btn-flat" href="" data-title="Update" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Actualizar"><span class="fa fa-edit"></span></a>
            </div>
            <div class="btn-group">
                <a class="btn btn-danger btn-xs btn-flat" href="" data-title="Delete" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Cancelar"><span class="fa fa-trash"></span></a>
            </div>
        </div>
    </div>
  <div class="box-header" id="header2">
        <form id="search-consolidate-formalized" method="POST" role="form">
            <div class="row"> 
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-location-arrow"></span>
                        </div>
                        <input type="text" class="form-control input-sm" id="consolidate-formalized" name="consolidated-formalized" title="" placeholder="Consolidado">
                    </div>
                    <small id="number_record" class="form-text text-muted">Consolidado.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-user"></span>
                        </div>
                        <input type="text" id="user" name="user"  class="form-control input-sm" placeholder="Nombre del usuario">
                    </div>
                    <small id="user" class="form-text text-muted">Usuario.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-plus-o"></span>
                        </div>
                        <input type="text" id="1" name="" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de creacion.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-check-o"></span>
                        </div>
                        <input type="text" id="2" name="" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de cierre.</small>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn bg-green btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Buscar filtros"><span class="fa fa-search"></span> Buscar</button>
                </div>
            </div>
        </form>
    </div>
<div class="box-body table-responsive">
        <table id="users-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center"><span class="fa fa-check-circle-o"></span> Elegir</th>
                    <th><span class="fa fa-cube"></span> Consolidado</th>
                    <th><span class="fa fa-user"></span> Usuario</th>
                    <th><span class="fa fa-calendar-plus-o"></span> Fecha de creacion</th>
                    <th><span class="fa fa-calendar-check-o"></span> Formalizado</th>
                </tr>
            </thead>
            <tbody>
                <tr class="success">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>is13758797380</td>
                    <td>Emanuel Parra</td>
                    <td>08/03/2018</td>
                    <td>09/03/2018</td>
                </tr>
                <tr class="success">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>123456789123</td>
                    <td>Ninoska Isea</td>
                    <td>08/03/2018</td>
                    <td>09/03/2018</td>
                </tr>
                <tr class="success">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>5151515565656</td>
                    <td>Julio Castillo</td>
                    <td>08/03/2018</td>
                    <td>09/03/2018</td>
                </tr>
                <tr class="success">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>5151515565656</td>
                    <td>Emanuel Parra</td>
                    <td>08/03/2018</td>
                    <td>09/03/2018</td>
                </tr>
                <tr class="success">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>5151515565656</td>
                    <td>Renny Suarez</td>
                    <td>08/03/2018</td>
                    <td>09/03/2018</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@include('modals.send_form')
@include('modals.send_edit_form')
@include('modals.send_show')
@endsection