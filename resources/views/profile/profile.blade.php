@extends('layouts.principal')

@section('headJs')
    <script>
        function GlobalData(){
            this.oUser = <?php echo json_encode($oUser); ?>;
            this.updateRoute = <?php echo json_encode(route('profile.update')); ?>;
        }

        var oServerData = new GlobalData();
    </script>
@endsection

@section('content')
<div class="card" id="profileApp">
    <div class="card-header">
        <h3>Mi perfil</h3>
        </div>
        <div class="card-body">
            <div class="col-md-12 grid-margin">
                <form class="forms-sample">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Usuario</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="username" placeholder="Usuario" v-model="username" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="email" placeholder="email" v-model="email">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Imagen de perfil</label>
                                    <div class="col-sm-9">
                                        <label for="imgProfile" class="drop-container" id="dropcontainer">
                                            <span class="drop-title">Arrastre el archivo aquí (máximo 20MB)</span>
                                                o
                                            <input type="file" ref='imgProfile' id="imgProfile" accept="image/png, image/jpeg" required style="width: 90%">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Cambiar contraseña</label>
                                    <div class="col-sm-9">
                                        <div class="checkbox-wrapper-33">
                                            <label class="checkbox">
                                                <input class="checkbox__trigger visuallyhidden" type="checkbox" v-model="changePass"/>
                                                <span class="checkbox__symbol">
                                                    <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 14l8 7L24 7"></path>
                                                    </svg>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Contraseña</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input :type="typeInputPass" class="form-control" placeholder="password" id="password" v-model="password"
                                            :disabled="changePass == false">
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-inverse-dark" type="button" v-on:click="showPass()">
                                                    <i :class="[ showPassword ? 'bx bx-show bx-sm' : 'bx bx-hide bx-sm' ]"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Confirmar contraseña</label>
                                    <div class="col-sm-9">
                                        <input :type="typeInputPass" class="form-control" id="confirmPassword" placeholder="confirmPassword" v-model="confirmPassword"
                                        :disabled="changePass == false">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button style="float: right" type="button" class="btn btn-primary" id="btn_save" v-on:click="update()">
                                    <b>Guardar</b>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footerScripts')
    <script type="text/javascript" src="{{ asset('myApp/profile/vue_profile.js') }}"></script>
@endsection