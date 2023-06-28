var app = new Vue({
    el: '#rolesVsPermissions',
    data: {
        oData: oServerData,
        lRoles: oServerData.lRoles,
        lApps: oServerData.lApps,
        lPermissions: null,
        modal_title: null,
        id_rol: null,
        id_app: null,
        rol: null,
        app_name: null,
        is_edit: false,
        vueUtils: new vueUtils(),
        cancel: null,
    },
    mounted(){
        self = this;

        $('.select2-class').select2({});

        $('#apps_list').select2({
            placeholder: 'Selecciona rol',
            data: self.lApps,
        }).on('select2:select', function(e) {
            self.id_app = e.params.data.id;
        });
    },
    methods: {
        async showModal(data){
            $('.collapse').each(function() { // Recorre todos los elementos con la clase collapse
                var $este = $(this); // Obtiene el objeto jQuery actual
                $este.collapse('hide'); // Cierra todos los elementos con la clase collapse
            });

            this.id_rol = data[indexesRolesVsPermissionsTable.id_role];
            this.id_app = data[indexesRolesVsPermissionsTable.id_app];
            this.rol = data[indexesRolesVsPermissionsTable.role];
            this.app_name = data[indexesRolesVsPermissionsTable.app_name];
            this.modal_title = 'Rol: ' + this.rol + ' Applicación: ' + this.app_name;

            await this.getRolPermissions()
                        .then((data) => {
                            $('#modal_rol_permissions').modal('show');
                        })
                        .catch((error) => {
                            console.log(error);
                            return
                        });
        },

        getRolPermissions(){
            SGui.showWaiting(15000);
            let route = this.oData.getRolPermissionsRoute;
            return new Promise((resolve, reject) =>
                axios.post(route, {
                    'id_rol': this.id_rol,
                })
                .then( result => {
                    let data = result.data;
                    if(data.success){
                        self.lPermissions = data.lPermissions;
                        SGui.showOk();
                        resolve(self.lPermissions);
                    }else{
                        SGui.showMessage('', data.message, data.icon);
                        reject(data.message);
                    }
                })
                .catch( function(error){
                    console.log(error);
                    SGui.showMessage('', error, 'error');
                    reject(error);
                })
            );
        },

        async updatePermissions(id_permission, event){
            let is_active = event.target.checked;
            let route = this.oData.updateRoute;
            axios.post(route, {
                'id_permission': id_permission,
                'is_active': is_active,
                'id_app': this.id_app,
                'id_rol': this.id_rol,
            })
            .then( result => {
                let data = result.data;
                createToast(data.message, data.type);
                if(!data.success){
                    $('#'+data.checkbox).prop('checked', data.checkbox_status);
                }
            })
            .catch( function(error){
                console.log(error);
                SGui.showMessage('', error, 'error');
            });
        }
    }
})