@extends('layouts.principal')

@section('headJs')
<script>
    function GlobalData(){
        this.lUsers = <?php echo json_encode($lUsers); ?>;
        this.lApps = <?php echo json_encode($lApps); ?>;
        this.getUserPermissionsRoute = <?php echo json_encode(route('usersvspermissions_getUserPermissions')); ?>;
        this.createRoute = <?php echo json_encode(route('usersvspermissions_create')); ?>;
        this.updateRoute = <?php echo json_encode(route('usersvspermissions_update')); ?>;
        this.deleteRoute = <?php echo json_encode(route('usersvspermissions_delete')); ?>;
    }
    var oServerData = new GlobalData();
    var indexesUsersVsPermissionsTable = {
                'id_user': 0,
                'id_app': 1,
                'username': 2,
                'full_name': 3,
                'app': 4,
            };

    var indexesPermissionsTable = {
                'id_permission': 0,
                'id_rol': 1,
                'Key': 2,
                'permiso': 3,
                'rol': 4,
                'checked': 5,
            };
</script>
@endsection

@section('content')
<div class="card" id="usersVsPermissions">
    <div class="card-header">
        <h3>Usuarios contra permisos</h3>
    </div>
    <div class="card-body">

        @include('usersVsPermissions.modal_user_permissions')

        <div class="row" style="margin-bottom: 0.7rem">
            <div class="col-12 col-xl-8 mb-xl-0">
                @include('layouts.buttons', ['show' => true])
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <label for="apps_list" class="col-form-label"><b>Applicación:</b></label>
                    <select class="select2-class form-control" name="apps_list" id="apps_list" ref="apps_list" style="width: 100%"></select>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="display expandable-table dataTable no-footer" id="table_UsersVsPermissions" width="100%" cellspacing="0">
                <thead>
                    <th>id_user</th>
                    <th>id_app</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Aplicación</th>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('footerScripts')

    <script>
        $(document).ready(function () {
            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    let SelectApp = parseInt( $('#apps_list').val(), 10 );
                    let filter = 0;

                    col_app = parseInt( data[indexesUsersVsPermissionsTable.id_app] );
                    if(col_app == SelectApp || SelectApp == 0){
                        return true;
                    } else if(SelectApp == -1){
                        return !(!!data[indexesUsersVsPermissionsTable.id_app]);
                    } else{
                        return false;
                    }
                }
            );

            $('#apps_list').change( function() {
                table['table_UsersVsPermissions'].draw();
            });
        });
    </script>

    @include('layouts.table_jsControll', [
                                            'table_id' => 'table_UsersVsPermissions',
                                            'colTargets' => [0],
                                            'colTargetsSercheable' => [1],
                                            'select' => true,
                                            'show' => true,
                                        ] )

    @include('layouts.table_jsControll', [
                                            'table_id' => 'table_permissions',
                                            'rowGroup' => 2,
                                            'colTargets' => [0],
                                            'colTargetsSercheable' => [1],
                                        ] )
    <script>
        var self;
    </script>
    <script type="text/javascript" src="{{ asset('myApp/usersVsPermissions/vue_usersVsPermissions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('myApp/Utils/datatablesUtils.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            drawTable('table_UsersVsPermissions', oServerData.lUsers);
        })
    </script>
    <script>
        function print(id_permission, id_rol){
            app.updatePermissions(id_permission, id_rol);
        }
    </script>
@endsection