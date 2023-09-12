var app = new Vue({
    el: '#profileApp',
    data: {
        oData: oServerData,
        oUser: oServerData.oUser,
        username: oServerData.oUser.username,
        email: oServerData.oUser.email,
        imgProfile: oServerData.oUser.imgProfile,
        changePass: false,
        password: null,
        confirmPassword: null,
        typeInputPass: 'password',
        showPassword: false,
    },
    mounted(){

    },
    methods:{
        update(){
            if(this.password != this.confirmPassword){
                SGui.showMessage("", "El campo 'Contraseña' y 'Confirmar contraseña' deben coincidir", "warning");
                return;
            }

            SGui.showWaiting(15000);

            let route = this.oData.updateRoute;
            const file = this.$refs.imgProfile.files[0];

            let formData = new FormData();
            formData.append('imgProfile', file);
            formData.append('email', this.email);
            formData.append('changePass', this.changePass);
            formData.append('password', this.password);
            formData.append('confirmPassword', this.confirmPassword);
            
            axios.post(route, formData, {
                headers: {
                    'Content-type': 'multipart/form-data'
                },
            })
            .then( result => {
                let data = result.data;
                if(data.success){
                    this.changePass = false;
                    this.password = null;
                    this.confirmPassword = null;
                    this.$refs.imgProfile.value = ''
                    SGui.showOk();
                }else{
                    SGui.showMessage('', data.message, data.icon);
                }
            })
            .catch( function(error){
                console.log(error);
                SGui.showError(error);
            })
        },

        showPass(){
            this.showPassword = this.showPassword ? false : true;
            this.typeInputPass = this.showPassword ? "text" : "password";
        },
    }
});