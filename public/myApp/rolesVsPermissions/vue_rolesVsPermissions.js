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

                            drawTable('table_permissions', self.lPermissions);
                            let elements = [];
                            for(oPer of self.lPermissions){
                                elements.push(
                                    '<div class="checkbox-wrapper-33">' +
                                        '<label class="checkbox">' +
                                            '<input id="permission' + oPer[indexesPermissionsTable.id_permission] + '" class="checkbox__trigger visuallyhidden" type="checkbox" '
                                                + (oPer[indexesPermissionsTable.checked] ? 'checked="true"' : '') + ' onclick="updatePermission(' + oPer[indexesPermissionsTable.id_permission] + ')">' +
                                            '<span class="checkbox__symbol">' +
                                                '<svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">' +
                                                    '<path d="M4 14l8 7L24 7"></path>' +
                                                '</svg>' +
                                            '</span>' +
                                        '</label>' +
                                    '</div>'
                                );
                            }

                            renderInTable('table_permissions', 1, elements);
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

        async updatePermissions(id_permission){
            let is_active = $('#permission'+id_permission).prop('checked');
            // let is_active = event.target.checked;
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