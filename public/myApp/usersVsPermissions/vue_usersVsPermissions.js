var app = new Vue({
    el: '#usersVsPermissions',
    data: {
        oData: oServerData,
        lUsers: oServerData.lUsers,
        lApps: oServerData.lApps,
        lPermissions: null,
        modal_title: null,
        id_user: null,
        id_app: null,
        username: null,
        full_name: null,
        app_name: null,
        is_edit: false,
        vueUtils: new vueUtils(),
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
            this.id_user = data[indexesUsersVsPermissionsTable.id_user];
            this.id_app = data[indexesUsersVsPermissionsTable.id_app];
            this.username = data[indexesUsersVsPermissionsTable.username];
            this.full_name = data[indexesUsersVsPermissionsTable.full_name];
            this.app_name = data[indexesUsersVsPermissionsTable.app];

            this.modal_title = '<strong>Usuario:</strong> ' + this.username + ' <strong>Applicación:</strong> ' + this.app_name;

            await this.getUserPermissions()
                        .then((data) => {
                            drawTable('table_permissions', self.lPermissions);
                            let elements = [];
                            for(oPer of self.lPermissions){
                                elements.push(
                                    '<div class="checkbox-wrapper-33">' +
                                        '<label class="checkbox">' +
                                            '<input id="permission' + oPer[indexesPermissionsTable.id_permission] + '" class="checkbox__trigger visuallyhidden" type="checkbox" '
                                                + (oPer[indexesPermissionsTable.checked] ? 'checked="true"' : '') + ' onclick="print(' + oPer[indexesPermissionsTable.id_permission] + ', ' + oPer[indexesPermissionsTable.id_rol] + ')">' +
                                            '<span class="checkbox__symbol">' +
                                                '<svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">' +
                                                    '<path d="M4 14l8 7L24 7"></path>' +
                                                '</svg>' +
                                            '</span>' +
                                        '</label>' +
                                    '</div>'
                                );
                            }

                            renderInTable('table_permissions', 3, elements);
                            $('#modal_user_permissions').modal('show');
                        })
                        .catch((error) => {
                            console.log(error);
                            return
                        });
        },

        getUserPermissions(){
            SGui.showWaiting(15000);
            let route = this.oData.getUserPermissionsRoute;
            return new Promise((resolve, reject) =>
                axios.post(route, {
                    'id_user': this.id_user,
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

        async updatePermissions(id_permission, id_rol){
            let is_active = $('#permission'+id_permission).prop('checked');
            let route = this.oData.updateRoute;
            axios.post(route, {
                'id_permission': id_permission,
                'is_active': is_active,
                'id_app': this.id_app,
                'id_user': this.id_user,
                'id_rol': id_rol,
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