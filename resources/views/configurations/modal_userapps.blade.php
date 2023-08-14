<div class="modal fade" id="modal_userapps" tabindex="-1" aria-labelledby="modal_userapps" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" style="max-width: 50rem">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_userapps" v-html="modal_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Usuario</label>
                                <div class="col-sm-9">
                                    <input v-model="username" type="text" class="form-control"
                                     id="inlineFormInputName2" placeholder="Usuario">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input v-model="email" type="email" class="form-control"
                                     id="inlineFormInputName2" placeholder="Email" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Apellido paterno</label>
                                <div class="col-sm-9">
                                    <input v-model="first_name" type="text" class="form-control" 
                                    id="inlineFormInputName2" placeholder="Apellido paterno" style="text-transform: uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Apellido materno</label>
                                <div class="col-sm-9">
                                    <input v-model="last_name" type="text" class="form-control" 
                                    id="inlineFormInputName2" placeholder="Apellido materno" style="text-transform: uppercase">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre(s)</label>
                                <div class="col-sm-9">
                                    <input v-model="names" type="text" class="form-control" 
                                    id="inlineFormInputName2" placeholder="Nombre(s)" style="text-transform: uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" v-show="!is_edit">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tipo</label>
                                <div class="col-sm-9">
                                    <select class="select2-class-modal form-control" name="select_type" id="select_type" ref="select_type" style="width: 100%;"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Acceso a aplicaciones</label>
                                <div class="col-sm-9">
                                    <select class="select2-class-modal form-control" name="select_app" id="select_app" ref="select_app" style="width: 100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Rol(es)</label>
                                <div class="col-sm-9">
                                    <select class="select2-class-modal form-control" multiple="multiple" name="select_rol[]" id="select_rol" ref="select_rol" style="width: 100%;"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="lConst.redirectsApps.hasOwnProperty(app_id) && !is_edit">
                        <div class="col-md-12">
                            <ul class="ulColumns3">
                                <li v-for="oCons in lConst.redirectsApps[app_id]">
                                    <div class="checkbox-wrapper-33 col-sm-5">
                                        <label class="checkbox">
                                            <input class="checkbox__trigger visuallyhidden" type="radio" name="radios"
                                                v-on:click="redirect_route = oCons.route"/>
                                            <span class="checkbox__symbol">
                                            <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 14l8 7L24 7"></path>
                                            </svg>
                                            </span>
                                            <p class="checkbox__textwrapper">@{{oCons.text}}</p>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary mr-2" v-on:click="save();">
                    @{{redirect_route == null ? 'Guardar' : 'Guardar y continuar'}}
                </button>
            </div>
        </div>
    </div>
</div>