<div class="modal fade" id="modal_rol_permissions" tabindex="-1" aria-labelledby="modal_rol_permissions" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50rem">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_rol_permissions">@{{ modal_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <template>
                    <div class="accordion" id="accordionExample">
                        <div v-for="permission in lPermissions">
                            <div class="card-header-primary" :id='"heading"+permission.key_code'>
                            <h2 class="mb-0">
                                <button class="btn btn-accordion btn-block text-left" type="button" data-toggle="collapse" :data-target='"#collapse"+permission.key_code' aria-expanded="true" :aria-controls="permission.key_code">
                                    @{{permission.key_code}}
                                </button>
                            </h2>
                            </div>
                            <div :id='"collapse"+permission.key_code' class="collapse" :aria-labelledby='"heading"+permission.key_code' data-parent="#accordionExample">
                                <div class="card-body">
                                    <ul class="ulColumns3">
                                        <li v-for="oPer in permission.permissions">
                                            <div class="checkbox-wrapper-33">
                                                <label class="checkbox">
                                                    <input :id="'permission'+oPer.id_permission" class="checkbox__trigger visuallyhidden" type="checkbox" :checked="oPer.checked"
                                                        v-on:click="updatePermissions(oPer.id_permission, $event);"
                                                    />
                                                    <span class="checkbox__symbol">
                                                    <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 14l8 7L24 7"></path>
                                                    </svg>
                                                    </span>
                                                    <p class="checkbox__textwrapper">@{{oPer.level}}</p>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>