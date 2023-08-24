$(document).ready(function() {
    $("#btnGuardar").click(function () {
        var datos= new FormData(document.getElementById("frm_permiso"));
        accion_registros({
            frm:"frm_permiso",
            btn:$(this),
            data:datos,
            ruta:urls.guardar,
            success:function(){
                    location.reload(true);
            },
            /*validaciones: function(){
                return true;
            },*/
        });
        
    });
    inicia_Datatable("#table_permisos");
});
