
$(document).ready(function() {
    $("#btnGuardar").click(function () {
        var datos= new FormData(document.getElementById("frm_menu"));
        accion_registros({
            frm:"frm_menu",
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
    //table_menu
    inicia_Datatable("#table_menu");
    /*
    var colorSelector = $('#colorSelector1, #colorSelector2, #colorSelector3, #colorSelector4, #colorSelector5, #colorSelector6, #colorSelector7');
    $(colorSelector).each(function(){console.log("entra");
        var selectorColor = $(this).prev().val();
        $(this).ColorPicker({
            color: selectorColor,
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val(hex);
                $(el).ColorPickerHide();
                $(el).css("background", "#"+hex);
                $(el).prev().val(hex);
            }
        }).bind('click', function(){
            var selectorColor = $(this).prev().val();
            $(this).ColorPickerSetColor(selectorColor);
        });
    });
    */

});
function eliminar_menu(id){
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