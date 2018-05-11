<div class="modal fade" id="modal-send-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="ModalLabel">
    <div class="modal-dialog modal-lg" style="width: 75%;" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="ModalLabel"></h4>
            </div>
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-5">
                        <b><span class="glyphicon glyphicon-calendar"></span> Fecha de creación:</b> <span class="f-create"></span>.
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <b><span class="glyphicon glyphicon-calendar"></span> Fecha de cierre:</b> <span class="f-close"></span>.
                    </div>
                    <hr>
                </div>
                @if(\Auth::user()->role_id == 1)
                <div class="row">
                    <form id="user-of-consolidated">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="form-group col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-user"></span>
                                </div>
                                <input type="text" class="js-example-basic-single" name="user_id" list="user_id" autocomplete="off">
                                <datalist id="user_id"></datalist>
                            </div>
                            <small id="user_id" class="form-text text-muted">Usuario poseedor del consolidado.</small>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary btn-xs btn-flat" data-toggle="tooltip"><span class="fa fa-plus"></span> Guardar</button>
                        </div>
                    </form>
                </div>
                @endif
                <div class="row">
                    <form id="tracking-form-register" action="{{ route('tracking.store') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="consolidated_id" name="consolidated_id" value="0">
                        <div class="form-group col-md-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-cart-plus"></span>
                                </div>
                                <select id="distributor_id" name="distributor_id" class="form-control input-sm" required=""></select>
                            </div>
                            <small id="distributor_id" class="form-text text-muted">Repartidor.</small>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-location-arrow"></span>
                                </div>
                                <input type="text" id="tracking" name="tracking" class="form-control input-sm" placeholder="Tracking" required="">
                            </div>
                            <small id="tracking" class="form-text text-muted">Número de tracking</small>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-commenting"></span>
                                </div>
                                <input type="text" id="description" name="description" class="form-control input-sm" placeholder="Descripción" required="">
                            </div>
                            <small id="description" class="form-text text-muted">Descripción</small>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-dollar"></span>
                                </div>
                                <input type="text" id="price" name="price" class="form-control input-sm" placeholder="USD $">
                            </div>
                            <small id="price" class="form-text text-muted">Valor declarado USD</small>
                        </div>
                        <div id="btn-create-tracking" class="col-md-1">
                            <button type="submit" class="btn btn-primary btn-xs btn-flat" data-toggle="tooltip" data-placement="top" title="Agregar tracking"><span class="fa fa-plus"></span> Añadir</button>
                        </div>
                        <div id="btns-edit-tracking" class="col-md-2 btn-group-xs hidden" role="toolbar">
                            <button id="btn-edit-tracking" type="button" class="btn btn-warning btn-xs btn-flat" data-toggle="tooltip" data-placement="top" title="Editar Tracking"><span class="fa fa-edit"></span> Editar</button>
                            <button id="btn-cancel-tracking" type="reset" class="btn btn-danger btn-xs btn-flat" data-toggle="tooltip" data-placement="top" title="Cancelar Edición"><span class="fa fa-close"></span> Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-body">
                <div class="box-body table-responsive">
                    <div class="col-md-12">
                        <table id="tracking-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Repartidor</th>
                                    <th># Tracking</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="consolidated-save" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-saved"></span> Guardar</button>
                <button type="button" id="consolidated-consolidated" class="btn btn-success btn-flat"><span class="fa fa-send"></span> Formalizar</button>
            </div>
        </div>
    </div>
</div>