<div class="modal fade" id="modal-send_formalizated_edit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="ModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="exampleModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Historial del consolidado:</h4>
                        <div class="pull-right">
                            <div class="btn-group"><button id="" type="button" data-title="Agregar" data-toggle="tooltip" data-target="" data-placement="top" rel="tooltip" title="Agregar evento" class="btn btn-primary btn-xs btn-flat"><span class="fa fa-plus"></span></button></div> 
                        </div>
                    </div>
                    <div class="box-header with-border">
                        <form action="">

                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-globe"></span>
                                    </div>
                                    <select id="verguito1" name="" class="form-control input-sm"></select>
                                </div>
                                <small id="" class="form-text text-muted">evento 1.</small>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-globe"></span>
                                    </div>
                                    <select id="verguito2" name="" class="form-control input-sm"></select>
                                </div>
                                <small id="" class="form-text text-muted">evento 2.</small>
                            </div>
                        </form>

                    </div>
                    <div class="box-body">
                        <div style="max-height: 250px; overflow: auto;">
                            <ul id="events-formalized" class="timeline">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Trakings registrados:</h4>
                    </div>
                    <div class="box-body">
                        <div class=" col-md-12 table-responsive">
                            <table id="table-edit-formalized" class="table table-striped table-bordered table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th>Repartidor</th>
                                        <th>Tracking</th>
                                        <th>Descripcion</th>
                                        <th>Valor declarado</th>
                                        <th>Agregado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script id="timeline-template" type="text/x-custom-template">
    <li id="fecha" class="time-label">
        <span class="bg-teal">
            10 Feb. 2014
        </span>
    </li>
    <li id="contenido">
        <i class="fa fa-truck bg-orange"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 13:05</span>

            <h3 class="timeline-header"><a href="#">Consolidado IS96891200658</a> ...</h3>

            <div class="timeline-body">
                Consolidado en ruta.
            </div>

            <div class="timeline-footer">
                <a id="delete-event" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></a>
            </div>
        </div>
    </li>
</script>
