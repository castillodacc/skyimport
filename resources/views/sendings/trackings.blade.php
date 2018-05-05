@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="box box-primary">  
    <div class="box-header with-border">
        <i class="box-title">Trackings en proceso:</i>
        <div class="pull-right box-tools">
            <div class="btn-group btn-group-xs">
                <button id="add-events" type="button" class="btn bg-primary btn-flat" data-title="add" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Actualizar estado" style="margin-right: 5px"><span class="fa fa-plus"></span> Actualizar estado</button>
                <button id="search-cons-a" type="button" class="btn bg-green btn-flat" data-title="tooltip"  data-toggle="tooltip" data-target="massive_event" data-placement="top" rel="tooltip" title="Buscar filtros"><span class="fa fa-search"></span> Filtros</button>
                <button type="button" class="btn btn-box-tool btn-flat" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
    </div>
    <div id="header-search-a" class="box-header">
        <form id="searchconsolidate" method="POST" role="form">
            <div class="row"> 
                <div class="form-group col-md-4">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-plus-o"></span>
                        </div>
                        <input type="text" id="create_date" name="create_date" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de creacion.</small>
                </div>
                <div class="form-group col-md-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-globe"></span>
                        </div>
                        <select name="event" id="event" class="form-control input-sm">
                        </select>
                    </div>
                    <small id="event" class="form-text text-muted">Evento.</small>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn bg-green btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Buscar filtros"><span class="fa fa-search"></span> Buscar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="box-body table-responsive">
        <div class="col-md-12">
            <table id="trackings-a-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="15%"><span class="fa fa-location-arrow"></span> Trackings</th>
                        <th><span class="fa fa-commenting"></span> Descripción</th>
                        <th width="15%"><span class="fa fa-cube"></span> Consolidado</th>
                        <th width="15%"><span class="fa fa-user"></span> Usuario</th>
                        <th width="15%"><span class="fa fa-calendar-plus-o"></span> Creación</th>
                        <th width="15%"><span class="fa fa-check-square-o"></span> Estado</th>
                        <th class="text-center" width="10%"><span class="fa fa-check-circle-o"></span> Seleccionar</th>
                    </tr>
                </thead>
            </table>
        </div> 
    </div>
</div>
@include('modals.massive_event')
@endsection