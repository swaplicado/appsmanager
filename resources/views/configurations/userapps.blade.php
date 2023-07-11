@extends('layouts.principal')

@section('content')
  <div class="card" id="UserAppsApp">
    <div class="card-header">
        <h3>Acceso de usuarios a aplicaciones</h3>
    </div>
    <div class="card-body">

        @include('configurations.modal_userapps')

        <div class="row">
            <div class="col-12">
                <div class="row" style="margin-bottom: 0.7rem">
                    <div class="col-12 col-xl-8 mb-xl-0">
                        @include('layouts.buttons', [
                                                        'create' => true,
                                                        'edit' => true,
                                                        'delete' => true,
                                                    ])
                    </div>
                </div>

                <div class="table-responsive hiddeToLoad">
                    <table class="display expandable-table dataTable no-footer" style="width: 100%" id="user_apps_table">
                        <thead>
                            <tr>
                                <th>user_id</th>
                                <th>Usuario</th>
                                @foreach ($lApps as $app)
                                    <th>{{ $app->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in lUsers">
                                <td scope="row">@{{ user.id }}</td>
                                <td scope="row">@{{ user.username }}</td>
                                    <td v-for="app in lApps" style="text-align: center;">
                                        <div class="col-1">
                                            <div class="checkbox-wrapper-33" style="width: 100%;">
                                                <label class="checkbox">
                                                    <input class="checkbox__trigger visuallyhidden" type="checkbox"
                                                        v-model="user[app.id_app]"
                                                        v-on:change="onChangeInput(user.id, app.id_app, !user[app.id_app])"
                                                    />
                                                    <span class="checkbox__symbol">
                                                        <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4 14l8 7L24 7"></path>
                                                        </svg>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection

@section('footerScripts')

    @include('layouts.table_jsControll', [
                                            'table_id' => 'user_apps_table',
                                            'colTargets' => [0],
                                            'colTargetsSercheable' => [],
                                            'select' => true,
                                            'create' => true,
                                            'edit' => true,
                                            'delete' => true,
                                        ] )

    <script src="{{ asset('js/vue/vue.js') }}"></script>
    <script>
        function ServerData() {
            this.lApps = @json($lApps);
            this.lUsers = @json($lUsers);
            this.lTypes = @json($lTypes);
            this.sUpdateRoute = @json(route('config.upd_user_app'));
            this.createUserRoute = @json(route('config.createUser'));
            this.getRolesAppRoute = @json(route('config.getRolesApp'));
            this.getUserRoute = @json(route('config.getUser'));
            this.updateUserRoute = @json(route('config.updateUser'));
            this.deleteUserRoute = @json(route('config.deleteUser'));
        }
        var lConst = @json($lConst);
        var oData = new ServerData();
        var indexes = {
            'user_id': 0,
            'username': 1
        };
    </script>
    
    <script src="{{ asset('js/myApp/userapps/VueApps.js') }}"></script>
    <script type="text/javascript" src="{{ asset('myApp/Utils/datatablesUtils.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            drawTable('user_apps_table');
        })
    </script>

@endsection
