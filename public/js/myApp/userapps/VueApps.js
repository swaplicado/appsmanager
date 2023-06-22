var app = new Vue({
    el: '#UserAppsApp',
    data: {
        message: "Hola!",
        lApps: oData.lApps,
        lUsers: oData.lUsers,
    },
    methods: {
        onChangeInput(idUser, idApp, isActive) {
            SGui.showWaiting(2000);
            axios.post(oData.sUpdateRoute, {
                user_id: idUser,
                app_id: idApp,
                is_active: isActive
              })
              .then(function (response) {
                SGui.showOk();
              })
              .catch(function (error) {
                SGui.showError(error.message);
              });
        }
    }
})