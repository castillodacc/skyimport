<div class="modal fade in" id="massive_event" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="exampleModalLabel"><span class="fa fa-globe"></span> Agregar Evento</h4>
            </div>
            <div class="modal-body">
                <form id="massive_event_form" method="POST" action="">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <input type="hidden" name="consolidated" >
                    <div class="row">
                        <div class="form-group col-md-8 col-md-offset-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-globe"></span>
                                </div>
                                <select name="event_to" id="event_to" class="form-control">
                                </select>
                            </div>
                            <small id="event" class="form-text text-muted">Seleccione el evento para agregar de forma masiva.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
                        <button id="save_events" type="submit" class="btn btn-primary btn-flat"><span class="fa fa-send"></span> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>