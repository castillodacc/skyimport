<div class="modal fade" id="modal_user_form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="exampleModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form id="user_form" method="POST">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-user-circle text-primary"></span>
                                </div>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Nombres">
                            </div>
                            <small id="name" class="form-text text-muted">Nombres del usuario.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-user-circle-o text-primary"></span>
                                </div>
                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Apellidos">
                            </div>
                            <small id="last_name" class="form-text text-muted">Apellidos del usuario.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-phone text-primary"></span>
                                </div>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Telefono">
                            </div>
                            <small id="phone" class="form-text text-muted">Telefono de contacto.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-envelope text-primary"></span>
                                </div>
                                <input type="email" id="email" name="email" class="form-control" placeholder="ejemplo@ejemplo.com">
                            </div>
                            <small id="email" class="form-text text-muted">Correo electronico.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-id-card text-primary"></span>
                                </div>
                                <input type="text" id="num_id" name="num_id" class="form-control" placeholder="Identificacion">
                            </div>
                            <small id="num_id" class="form-text text-muted">Documento de identidad.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-globe text-primary"></span>
                                </div>
                                <select id="country_id" name="country_id" class="form-control"></select>
                            </div>
                            <small id="country_id" class="form-text text-muted">Pais de origen.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-map text-primary"></span>
                                </div>
                                <input type="text" id="city" name="city" class="form-control" placeholder="Ciudad">
                            </div>
                            <small id="city" class="form-text text-muted">Ciudad de origen.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-toggle-on text-primary"></span>
                                </div>
                                <select id="role_id" name="role_id" class="form-control"></select>
                            </div>
                            <small id="role_id" class="form-text text-muted">Rol del usuario.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-map text-primary"></span>
                                </div>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
                            </div>
                            <small id="password" class="form-text text-muted">Contraseña.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-toggle-on text-primary"></span>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirmación de Contraseña.">
                            </div>
                            <small id="" class="form-text text-muted">Confirmación de Contraseña.</small>
                        </div>     
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6"> 
                            <textarea id="address" name="address" class="form-control" placeholder="Direccion principal"></textarea>
                            <small  class="form-text text-muted" id="address">Direccion principal del usuario.</small>
                        </div>
                        <div class="form-group col-md-6"> 
                            <textarea id="address_two" name="address_two" class="form-control" placeholder="Direccion secundaria"></textarea>
                            <small id="address_two" class="form-text text-muted">Direccion secundaria del usuario.</small>
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