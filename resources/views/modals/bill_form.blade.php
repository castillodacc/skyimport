<div class="modal fade in" id="modal-bill-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="exampleModalLabel"><span class="fa fa-dollar"></span> Facturar</h4>
            </div>
            <div class="modal-body">
                <form id="price_form" method="POST" action="">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <input type="hidden" name="consolidated" >
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-balance-scale"></span>
                                </div>
                                <input type="text" id="weight" name="weight" placeholder="Lb" class="form-control">
                            </div>
                            <small id="weight" class="form-text text-muted">Peso total del consolidado en Libras.</small>
                        </div>
                         <div class="form-group col-md-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-dollar"></span>
                                </div> 
                                <input type="text" id="bill" name="bill" placeholder="Total a facturar (USD)" class="form-control">
                            </div>                        
                            <small id="bill" class="form-text text-muted">Precio total a facturar en USD.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-flat"><span class="fa fa-send"></span> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>