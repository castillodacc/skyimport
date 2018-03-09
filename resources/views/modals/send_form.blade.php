<div class="modal fade" id="send_form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="exampleModalLabel"></h4>
            </div>
            <form id="send_form" method="POST">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-cart-plus text-primary"></span>
                                </div>
                                <select id="courier" name="courier" class="form-control input-sm"></select>
                            </div>
                            <small id="courier" class="form-text text-muted">Repartidor.</small>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-location-arrow text-primary"></span>
                                </div>
                                <input type="text" id="tracking" name="tracking" class="form-control input-sm" placeholder="Traking">
                            </div>
                            <small id="tracking" class="form-text text-muted">Numero de tracking</small>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-commenting text-primary"></span>
                                </div>
                                <input type="text" id="description" name="description" class="form-control input-sm" placeholder="Descripcion">
                            </div>
                            <small id="description" class="form-text text-muted">Descripcion</small>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-dollar text-primary"></span>
                                </div>
                                <input type="text" id="price" name="price" class="form-control input-sm" placeholder="Valor en $">
                            </div>
                            <small id="price" class="form-text text-muted">Valor declarado $</small>
                        </div>
                        <div class="form-group col-md-1">
                            <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Agregar tracking"><span class="fa fa-plus"></span></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="box-body table-responsive">
                        <table id="users-table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Repartidor</th>
                                    <th># Traking</th>
                                    <th>Descripcion</th>
                                    <th>Valor declarado</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Amazon</td>
                                    <td>5151515151</td>
                                    <td>Phone</td>
                                    <td>$ 444</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip"
                                        title="Editar"><span class="fa fa-pencil"></span></a>
                                        <a class="btn btn-danger btn-xs" data-toggle="tooltip"
                                        title="Cancelar"><span class="fa fa-close"></span></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>FedEx</td>
                                    <td>668855665</td>
                                    <td>Motherboard</td>
                                    <td>$ 200</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip"
                                        title="Editar"><span class="fa fa-pencil"></span></a>
                                        <a class="btn btn-danger btn-xs" data-toggle="tooltip"
                                        title="Cancelar"><span class="fa fa-close"></span></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>FedEx</td>
                                    <td>668855665</td>
                                    <td>Motherboard</td>
                                    <td>$ 200</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip"
                                        title="Editar"><span class="fa fa-pencil"></span></a>
                                        <a class="btn btn-danger btn-xs" data-toggle="tooltip"
                                        title="Cancelar"><span class="fa fa-close"></span></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>FedEx</td>
                                    <td>668855665</td>
                                    <td>Motherboard</td>
                                    <td>$ 200</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip"
                                        title="Editar"><span class="fa fa-pencil"></span></a>
                                        <a class="btn btn-danger btn-xs" data-toggle="tooltip"
                                        title="Cancelar"><span class="fa fa-close"></span></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>FedEx</td>
                                    <td>668855665</td>
                                    <td>Motherboard</td>
                                    <td>$ 200</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip"
                                        title="Editar"><span class="fa fa-pencil"></span></a>
                                        <a class="btn btn-danger btn-xs" data-toggle="tooltip"
                                        title="Cancelar"><span class="fa fa-close"></span></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col col-xs-8">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><span class="fa fa-send"></span> Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>