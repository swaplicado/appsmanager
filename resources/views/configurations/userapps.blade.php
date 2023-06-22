@extends('layouts.principal')

@section('content')
  <div id="UserAppsApp">
    <div class="row">
        <h3>Acceso de usuarios a aplicaciones</h3>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped table-inverse" style="width: 100%" id="user_apps_table">
                <thead class="thead-inverse">
                    <tr>
                        <th>Usuario</th>
                        @foreach ($lApps as $app)
                            <th>{{ $app->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in lUsers">
                        <td scope="row">@{{ user.username }}</td>
                            <th v-for="app in lApps" style="text-align: center;">
                                <input class="form-check-input" type="checkbox" v-model="user[app.id_app]" v-on:change="onChangeInput(user.id, app.id_app, !user[app.id_app])">
                            </th>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
@endsection

@section('footerScripts')
    <script src="{{ asset('js/axios/axios.min.js') }}"></script>
    <script src="{{ asset('js/vue/vue.js') }}"></script>
    <script>
        function ServerData() {
            this.lApps = @json($lApps);
            this.lUsers = @json($lUsers);
            this.sUpdateRoute = @json(route('config.upd_user_app'));
        }

        var oData = new ServerData();
    </script>
    
    <script src="{{ asset('js/myApp/userapps/VueApps.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#user_apps_table').DataTable();
        });
    </script>

@endsection
