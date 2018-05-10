@extends('vendor.adminlte.layouts.app')
@section('main-content')
<div class="box box-primary">  
    <div class="box-header with-border">
        <i class="box-title">Consolidados abiertos:</i>
        <div class="pull-right box-tools">
            <div class="btn-group btn-group-xs">
                <button id="search-cons-a" type="button" class="btn bg-green btn-flat" data-title="Search"><span class="fa fa-search"></span> Filtros</button>
                <button type="button" class="btn btn-box-tool btn-flat" data-widget="collapse"><i class="fa fa-minus"></i>
                </button> 
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
                    <small id="create_date" class="form-text text-muted">Fecha de creación.</small>
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
                    <button type="submit" class="btn bg-green btn-sm btn-flat"><span class="fa fa-search"></span> Buscar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="box-body table-responsive">
        <div class="col-md-12">
            <table id="consolidated-a-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Consolidado</th>
                        <th width="20%">Usuario</th>
                        <th width="12%">Creación</th>
                        <th width="15%">Estado</th>
                        <th>Trackings</th>
                        <th width="13%">Cierre</th>
                        <th class="text-center" width="30%">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div> 
    </div>
    <div class="box-footer">
        <a id="addForm" href="#" class="btn btn-primary btn-sm btn-flat"><span class="fa fa-plus"></span> Nuevo consolidado</a>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <i class="box-title">Consolidados formalizados:</i>
        <div class="pull-right">
            <div class="btn-group btn-group-xs">
                <a id="search-cons-b" class="btn bg-green btn-flat" href="#"><span class="fa fa-search"></span> Filtros</a>
                <button type="button" class="btn btn-box-tool btn-flat" data-widget="collapse"><i class="fa fa-minus"></i>
                </button> 
            </div>
        </div>
    </div>
    <div class="box-header" id="header-search-b">
        <form id="search-consolidate-formalized" method="POST" role="form">
            <div class="row"> 
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-location-arrow"></span>
                        </div>
                        <input type="text" class="form-control input-sm" id="consolidate-formalized" name="consolidated_formalized" title="" placeholder="Consolidado">
                    </div>
                    <small id="number_record" class="form-text text-muted">Consolidado.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-plus-o"></span>
                        </div>
                        <input type="text" id="1" name="created_at" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de creación.</small>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar-check-o"></span>
                        </div>
                        <input type="text" id="2" name="closed_at" class="form-control input-sm" placeholder="dd/mm/aaaa">
                    </div>
                    <small id="create_date" class="form-text text-muted">Fecha de cierre.</small>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn bg-green btn-sm btn-flat"><span class="fa fa-search"></span> Buscar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="box-body table-responsive">
        <div class="col-md-12">
            <table id="consolidated-b-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Consolidado</th>
                        <th>Usuario</th>
                        <th>Creación</th>
                        <th>Estado</th>
                        <th>Trackings</th>
                        <th>Formalizado</th>
                        <th class="text-center" width="48%">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('modals.send_form')
@include('modals.send_formalizated_edit')
@include('modals.bill_form')
@endsection