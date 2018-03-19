<div class="modal fade" id="modal-send-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="ModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                <div class="row">
                    <form id="tracking-form-register" action="{{ route('tracking.store') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="consolidated_id" name="consolidated_id" value="0">
                        <div class="form-group col-md-3">
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
                                <input type="text" id="tracking" name="tracking" class="form-control input-sm" placeholder="Traking" required="">
                            </div>
                            <small id="tracking" class="form-text text-muted">Numero de tracking</small>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-commenting"></span>
                                </div>
                                <input type="text" id="description" name="description" class="form-control input-sm" placeholder="Descripcion" required="">
                            </div>
                            <small id="description" class="form-text text-muted">Descripcion</small>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Lb
                                </div>
                                <input type="number" id="weight" name="weight" class="form-control input-sm" placeholder="99" required="">
                            </div>
                            <small id="weight" class="form-text text-muted">Peso en Libras</small>
                        </div>
                        <div class="form-group col-md-1">
                            <button type="submit" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="Agregar tracking"><span class="fa fa-plus"></span></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <table id="tracking-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Repartidor</th>
                                <th># Traking</th>
                                <th>Descripcion</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Amazon</td>
                                <td>5151515151</td>
                                <td>Phone</td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-xs btn-flat" data-toggle="tooltip"
                                    title="Editar"><span class="fa fa-pencil"></span></a>
                                    <a class="btn btn-danger btn-xs btn-flat" data-toggle="tooltip"
                                    title="Cancelar"><span class="fa fa-close"></span></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
                <button type="button" class="btn btn-primary btn-flat"><span class="fa fa-send"></span> Guardar</button>
                <button type="button" class="btn btn-success btn-flat"><span class="fa fa-send"></span> Consolidar</button>
            </div>
        </div>
    </div>
</div>