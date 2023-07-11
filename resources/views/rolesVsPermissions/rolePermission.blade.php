@extends('layouts.principal')

@section('headJs')
<script>
    function GlobalData(){
        this.lRoles = <?php echo json_encode($lRoles); ?>;
        this.lApps = <?php echo json_encode($lApps); ?>;
        this.getRolPermissionsRoute = <?php echo json_encode(route('rolesvspermissions_getRolPermissions')); ?>;
        this.createRoute = <?php echo json_encode(route('rolesvspermissions_create')); ?>;
        this.updateRoute = <?php echo json_encode(route('rolesvspermissions_update')); ?>;
        this.deleteRoute = <?php echo json_encode(route('rolesvspermissions_delete')); ?>;
    }
    var oServerData = new GlobalData();
    var indexesRolesVsPermissionsTable = {
                'id_role': 0,
                'id_app': 1,
                'role': 2,
                'app_name': 3,
            };

    var indexesPermissionsTable = {
                'id_permission': 0,
                'Key': 1,
                'permiso': 2,
                'checked': 3,
            };
</script>
@endsection

@section('content')
<div class="card" id="rolesVsPermissions">
    <div class="card-header">
        <h3>Roles contra permisos</h3>
    </div>
    <div class="card-body">

        @include('rolesVsPermissions.modal_rol_permissions')

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
            <table class="display expandable-table dataTable no-footer" id="table_RolesVsPermissions" width="100%" cellspacing="0">
                <thead>
                    <th>id_rol</th>
                    <th>id_app</th>
                    <th>Rol</th>
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

                col_app = parseInt( data[indexesRolesVsPermissionsTable.id_app] );
                if(col_app == SelectApp || SelectApp == 0){
                    return true;
                } else if(SelectApp == -1){
                    return !(!!data[indexesRolesVsPermissionsTable.id_app]);
                } else{
                    return false;
                }
            }
            );

            $('#apps_list').change( function() {
                table['table_RolesVsPermissions'].draw();
            });
        });
    </script>

    @include('layouts.table_jsControll', [
                                            'table_id' => 'table_RolesVsPermissions',
                                            'colTargets' => [0],
                                            'colTargetsSercheable' => [1],
                                            'select' => true,
                                            'show' => true,
                                        ] )

    @include('layouts.table_jsControll', [
                                            'table_id' => 'table_permissions',
                                            'rowGroup' => 1,
                                            'colTargets' => [0, 1],
                                            'colTargetsSercheable' => [],
                                        ] )
    <script>
        var self;
    </script>
    <script type="text/javascript" src="{{ asset('myApp/rolesVsPermissions/vue_rolesVsPermissions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('myApp/Utils/datatablesUtils.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            drawTable('table_RolesVsPermissions', oServerData.lRoles);
        })
    </script>
    <script>
        function updatePermission(id_permission){
            app.updatePermissions(id_permission);
        }
    </script>
@endsection