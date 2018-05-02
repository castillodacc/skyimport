<div class="modal fade" id="modal-send-show" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="ModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-aqua">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="exampleModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Datos del consolidado:</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="records" class="table table-striped table-bordered table-hover table-condensed">
                                <tbody>
                                    <tr>
                                        <th class="col-md-3">Consolidado:</th>
                                        <td class="col-md-3" id="number"></td>
                                        <th class="col-md-3">Usuario:</th>
                                        <td class="col-md-3" id="user"></td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de creacion:</th>
                                        <td class="" id="created_date"></td>
                                        <th>Fecha de cierre:</th>
                                        <td class="" id="closed_date"></td>
                                    </tr>
                                    <tr>
                                        <th>Estado:</th>
                                        <td id="state" class=""></td>
                                        <th>Cantidad de trackings:</th>
                                        <td class="" id="cant"></td>
                                    </tr>
                                    <tr>
                                        <th>Valor total declarado:</th>
                                        <td class="" id="value"></td>
                                        <th>Peso total:</th>
                                        <td class="" id="weight"></td>
                                    </tr>
                                    <tr>
                                        <th>Precio total facturado:</th>
                                        <td class="" id="bill"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Trackings registrados:</h4>
                    </div>
                    <div class="box-body">
                        <div class=" col-md-12 table-responsive">
                            <table id="table-view-trackings" class="table table-striped table-bordered table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th>Repartidor</th>
                                        <th>Tracking</th>
                                        <th>Descripcion</th>
                                        <th>Valor declarado</th>
                                        <th>Agregado hace</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
            </div>
        </div>
    </div>
</div>


