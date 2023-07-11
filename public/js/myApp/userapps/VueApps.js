var self
var app = new Vue({
    el: '#UserAppsApp',
    data: {
        message: 'Hola!',
        lApps: oData.lApps,
        lUsers: oData.lUsers,
        lTypes: oData.lTypes,
        lConst: lConst,
        modal_title: null,
        username: null,
        email: null,
        first_name: null,
        last_name: null,
        names: null,
        type: null,
        accessApps: [],
        is_edit: false,
        user_id: null,
        user_apps: [],
        lAssignedRoles: [],
        app_id: null,
        roles_ids: [],
        redirect_route: null
    },
    mounted () {
        self = this;

        dataTypes = [];
        for (const oType of this.lTypes) {
            dataTypes.push({ id: oType.id_typesuser, text: oType.name });
        }

        $('.select2-class-modal').select2({
            dropdownParent: $('#modal_userapps')
        })

        $('#select_type')
            .select2({
                placeholder: 'Tipo de usuario',
                data: dataTypes
            })
            .on('select2:select', function (e) {
                self.type = e.params.data.id;
            })

        $('#select_type').val('').trigger('change');
    },
    methods: {
        onChangeInput (idUser, idApp, isActive) {
            SGui.showWaiting(2000);
            axios
                .post(oData.sUpdateRoute, {
                    user_id: idUser,
                    app_id: idApp,
                    is_active: isActive
                })
                .then(function (response) {
                    SGui.showOk();
                })
                .catch(function (error) {
                    SGui.showError(error.message);
                })
        },

        async createModal () {
            this.cleanData();
            this.is_edit = false;

            this.modal_title = 'Crear usuario';

            $('#select_type').val('').trigger('change');

            let dataApps = [];
            for (const oApp of this.lApps) {
                dataApps.push({ id: oApp.id_app, text: oApp.name });
            }

            $('#select_app')
                .select2({
                    placeholder: 'Aplicación',
                    data: dataApps
                })
                .on('select2:select', function (e) {
                    self.app_id = e.params.data.id;
                    self.getRolesApp();
                    self.redirect_route = null;
                })

            $('#select_app').val('').trigger('change');

            $('#modal_userapps').modal('show');
        },

        async editModal (data) {
            SGui.showWaiting(15000);
            this.cleanData();
            
            this.is_edit = true;
            this.user_id = data[indexes.user_id];
            await this.getUser();

            let dataApps = [];
            for (const oApp of this.user_apps) {
                dataApps.push({ id: oApp.id_app, text: oApp.name });
            }

            $('#select_app')
                .select2({
                    placeholder: 'Aplicación',
                    data: dataApps
                });

            $('#select_app').val('').trigger('change');

            $('#select_app').on('select2:select', function (e) {
                    self.app_id = e.params.data.id;
                    self.getRolesApp();
                    self.redirect_route = null;
                });

            $('#modal_userapps').modal('show');
            Swal.close();
        },

        getUser(){
            return new Promise((resolve, reject) => 
                axios.post(oData.getUserRoute,{
                    'user_id': this.user_id,
                })
                .then(result => {
                    let data = result.data;
                    if(data.success){
                        this.user_id = data.oUser.id;
                        this.username = data.oUser.username;
                        this.email = data.oUser.email;
                        this.first_name = data.oUser.first_name;
                        this.last_name = data.oUser.last_name;
                        this.names = data.oUser.names;
                        this.user_apps = data.lApps;
                        this.roles_ids = [];
                        resolve('ok');
                    }else{
                        SGui.showMessage('', data.message, data.icon);
                        reject('error');
                    }
                })
                .catch(function(error){
                    console.log(error);
                    SGui.showError(error);
                    reject('error');
                })
            );
        },

        getRolesApp () {
            $('#select_rol').empty();
            axios
                .post(oData.getRolesAppRoute, {
                    app_id: self.app_id,
                    user_id: self.user_id,
                })
                .then(result => {
                    let data = result.data;
                    if (data.success) {
                        this.lAssignedRoles = data.lAssignedRoles;

                        $('#select_rol')
                            .select2({
                                placeholder: 'Rol(es)',
                                data: data.lRoles
                            })
                            .on('change', function (e) {
                                self.roles_ids = $(this).val();
                            })

                        if(this.is_edit){
                            if(this.lAssignedRoles.length > 0){
                                let ids = this.lAssignedRoles.map((object) => object.role_id);
                                $('#select_rol').val(ids).trigger('change');
                            }
                        }
                    } else {
                        SGui.showMessage('', data.message, data.icon);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    SGui.showError(data.message);
                })
        },

        checkFormData () {
            let message = '';
            
            if (!this.username) {
                message = 'Debe introducir el usuario. ';
                return [false, message];
            }

            if (!this.email) {
                message = 'Debe introducir un email de usuario. ';
                return [false, message];
            }

            if (!this.first_name) {
                message = 'Debe introducir el apellido paterno del usuario. ';
                return [false, message];
            }

            if (!this.last_name) {
                message = 'Debe introducir el apellido materno del usuario. ';
                return [false, message];
            }

            if (!this.names) {
                message = 'Debe introducir el nombre del usuario. ';
                return [false, message];
            }

            if (!this.type && !this.is_edit) {
                message = 'Debe introducir el tipo de usuario. ';
                return [false, message];
            }

            if (this.roles_ids.length < 1 && !this.is_edit) {
                message = 'Debe introducir por lo menos un rol ';
                return [false, message];
            }

            return [true, ''];
        },

        save () {
            let result = this.checkFormData();

            if (!result[0]) {
                SGui.showMessage('', result[1], 'warning');
                return
            }

            SGui.showWaiting(15000);
            let route = !this.is_edit ? oData.createUserRoute : oData.updateUserRoute;

            axios
                .post(route, {
                    username: this.username,
                    email: this.email,
                    first_name: this.first_name,
                    last_name: this.last_name,
                    names: this.names,
                    type: this.type,
                    app_id: this.app_id,
                    roles_ids: this.roles_ids,
                    user_id: this.user_id,
                })
                .then(result => {
                    let data = result.data;
                    if (data.success) {
                        this.lUsers = data.lUsers;
                        SGui.showOk();
                        $('#modal_userapps').modal('hide');
                        if(!!this.redirect_route){
                            window.open(this.redirect_route, '_blank');
                        }
                    } else {
                        SGui.showMessage('', data.message, data.icon);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    SGui.showError(error);
                })
        },

        deleteRegistry (data) {
            Swal.fire({
                title: '¿Desea eliminar el usuario ' + data[indexes.username] + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteUser(data[indexes.user_id]);
                }
            })
        },

        deleteUser(user_id){
            SGui.showWaiting(15000);
            let route = oData.deleteUserRoute;
            axios.post(route, {
                'user_id': user_id,
            })
            .then(result => {
                let data = result.data;
                if(data.success){
                    this.lUsers = data.lUsers;
                    SGui.showOk();
                }else{
                    SGui.showMessage('', data.message, data.icon);
                }
            })
            .catch(function(error){
                console.log(error);
                SGui.showError(error);
            })
        },

        cleanData(){
            this.modal_title = null;
            this.username = null;
            this.email = null;
            this.first_name = null;
            this.last_name = null;
            this.names = null;
            this.type = null;
            this.redirect_route = null;
            this.app_id = null;
            this.roles_ids = [];

            $('#select_app').empty();
            $('#select_rol').empty();
        }
    }
})
