<div class="modal fade" id="change_password_form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="exampleModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form id="change_password_form" method="POST">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-key text-primary"></span>
                                </div>
                                <input type="text" id="old_password" name="old_password" class="form-control" placeholder="Contraseña actual">
                            </div>
                            <small id="old_password" class="form-text text-muted">Contraseña actual.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-lock text-primary"></span>
                                </div>
                                <input type="text" id="new_password" name="new_password" class="form-control" placeholder="Nueva contraseña">
                            </div>
                            <small id="new_password" class="form-text text-muted">Nueva contraseña.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-unlock text-primary"></span>
                                </div>
                                <input type="text" id="confirm_password" name="confirm_password" class="form-control" placeholder="Repita nueva contraseña">
                            </div>
                            <small id="confirm_password" class="form-text text-muted">Repita nueva contraseña.</small>
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
</div>