<div class="modal fade" id="modal_user_permissions" tabindex="-1" aria-labelledby="modal_user_permissions" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50rem">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_user_permissions" v-html="modal_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="display expandable-table dataTable no-footer" id="table_permissions" width="100%" cellspacing="0">
                    <thead>
                        <th>id_permission</th>
                        <th>id_rol</th>
                        <th>Nombre</th>
                        <th>Permiso</th>
                        <th>Rol</th>
                        <th>Asignado</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>