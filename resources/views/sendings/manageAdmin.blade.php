@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="box box-primary">  
    <div class="box-header with-border">
        <h3 class="box-title">Consolidados abiertos</h3>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn bg-green btn-xs btn-flat" href="" data-title="Search" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Buscar filtros"><span class="fa fa-search"></span></a>
            </div>
            <div class="btn-group">
                <a class="btn btn-warning btn-xs btn-flat" href="" data-title="Extend" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Extender consolidado"><span class="fa fa-calendar-plus-o"></span></a>
            </div>
            <div class="btn-group">
                <a class="btn btn-info btn-xs btn-flat" href="" data-title="Show" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Mostrar consolidado"><span class="fa fa-eye"></span></a>
            </div>
            <div class="btn-group">
                <a class="btn btn-danger btn-xs btn-flat" href="" data-title="Delete" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Cancelar"><span class="fa fa-trash"></span></a>
            </div>
        </div>
    </div>
    <div class="box-header" id="header2">
        <form id="searchconsolidate" method="POST" role="form">
            <div class="row"> 
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-location-arrow"></span>
                        </div>
                        <input type="text" class="form-control input-sm" id="consolidated" name="consolidated" pattern="" title="" placeholder="Consolidado">
                    </div>
                    <small id="number_record" class="form-text text-muted">Consolidado.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-user"></span>
                        </div>
                        <input type="text" id="user" pattern="" name="user"  class="form-control input-sm" placeholder="Nombre del usuario">
                    </div>
                    <small id="user" class="form-text text-muted">Usuario.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-plus-o"></span>
                        </div>
                        <input type="text" id="create_date" pattern="" name="create_date" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de creacion.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-times-o"></span>
                        </div>
                        <input type="text" id="create_date" pattern="" name="create_date" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de cierre.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-check"></span>
                        </div>
                        <select id="status" name="status" class="form-control input-sm"></select>
                    </div>
                    <small id="status" class="form-text text-muted">Estado.</small>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn bg-green btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Buscar filtros"><span class="fa fa-search"></span> Buscar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="box-body table-responsive">
        <table id="users-table" class="table table-sm table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center"><span class="fa fa-check-circle-o"></span> Elegir</th>
                    <th><span class="fa fa-cube"></span> Consolidado</th>
                    <th><span class="fa fa-user"></span> Usuario</th>
                    <th><span class="fa fa-calendar-plus-o"></span> Fecha de creacion</th>
                    <th><span class="fa fa-calendar-times-o"></span> Fecha de cierre</th>
                    <th><span class="fa fa-check-square-o"></span> Estado</th>
                    <th><span class="fa fa-hourglass-start"></span> Auto-Formalizacion</th>
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>is13758797380</td>
                    <td>Emanuel Parra</td>
                    <td>09/03/2018</td>
                    <td>09/03/2018</td>
                    <td><span class="label label-info">Pendiente formalizacion</span></td>
                    <td>Tiempo restante</td>
                </tr>
                <tr class="">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>123456789123</td>
                    <td>Renny Suarez</td>
                    <td>09/03/2018</td>
                    <td>09/03/2018</td>
                    <td><span class="label label-warning">Tiempo extendido</span>
                    <td>Tiempo restante</td>
                </tr>
                <tr class="">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>5151515565656</td>
                    <td>Julio Castillo</td>
                    <td>08/03/2018</td>
                    <td>09/03/2018</td>
                    <td><span class="label label-info">Pendiente formalizacion</span></td>
                    <td>Tiempo restante</td>
                </tr>
                <tr class="">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>5151515565656</td>
                    <td>Ninoska Isea</td>
                    <td>08/03/2018</td>
                    <td>09/03/2018</td>
                    <td><span class="label label-warning">Tiempo extendido</span>
                    <td>Tiempo restante</td>
                </tr>
                <tr class="">
                    <td class="text-center"><input type="radio" name=""></td>
                    <td>5151515565656</td>
                    <td>Reinmy Paz</td>
                    <td>08/03/2018</td>
                    <td>09/03/2018</td>
                    <td><span class="label label-warning">Tiempo extendido</span>
                    <td>Tiempo restante</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="box-footer">
            <a id="addform" href="" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-placement="top" data-target="#send_form" title="Crear consolidado"><span class="fa fa-plus"></span> Nuevo consolidado</a>
    </div>
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
        <form id="searchconsolidate" method="POST" role="form">
            <div class="row"> 
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-location-arrow"></span>
                        </div>
                        <input type="text" class="form-control input-sm" id="consolidated" name="consolidated" pattern="" title="" placeholder="Consolidado">
                    </div>
                    <small id="number_record" class="form-text text-muted">Consolidado.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-user"></span>
                        </div>
                        <input type="text" id="user" pattern="" name="user"  class="form-control input-sm" placeholder="Nombre del usuario">
                    </div>
                    <small id="user" class="form-text text-muted">Usuario.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-plus-o"></span>
                        </div>
                        <input type="text" id="create_date" pattern="" name="create_date" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de creacion.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-check-o"></span>
                        </div>
                        <input type="text" id="create_date" pattern="" name="create_date" class="form-control input-sm" placeholder="dd/mm/aaaa">
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
@endsection