$(document).ready(function() {

    $(".selectpicker").selectpicker();
    $("#btnGuardar").click(function () {
        var datos= new FormData(document.getElementById("frm_sucursal"));
        var countFiles = $('#fileUpload').get(0).dropzone.files.length;
        if (countFiles > 0) {
            var files = $('#fileUpload').get(0).dropzone.getAcceptedFiles();
            datos.append('logotipo', files[0]);
            //console.log(files[x]);
        }
        accion_registros({
            frm:"frm_sucursal",
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
});
function eliminar_sucursal(id){
    var datos= new FormData();
    datos.append("id_reg",id);
    accion_registros({
        accion:"Eliminar",
        btn:$("btnDelete_"+id),
        data:datos,
        ruta:urls.eliminar,
        success:function(){
            location.reload(true);
        },
        /*validaciones: function(){
            return true;
        },*/
    });
}